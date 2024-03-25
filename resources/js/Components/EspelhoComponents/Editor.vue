<script setup lang="ts">
import { ref, onBeforeMount } from 'vue';
import { v4 as uuidv4 } from 'uuid';
import { format } from 'date-fns';
import {
  Promotoria,
  GrupoPromotoria,
  Espelho,
  Promotor,
  Evento,
  UrgenciaAtendimentoClientSide, Atribuicoes, UrgenciaAtendimentoServeSide
} from '@/types';

const emit = defineEmits([
  'update:periodoEspelho',
  'update:grupoDeTodasAsPromotorias',
  'update:dadosDosAtendimentosUrgencia',
  'update:atribuicao',
  'update:ListaEventos'
]);

const props = defineProps({
  espelho: {
    type: Object as () => Espelho,
    required: true,
  },
  promotores: {
    type: Array as () => Promotor[],
    required: true,
  },
  promotorias: {
    type: Array as () => Promotoria[],
    required: true,
  },
  eventos: {
    type: Array as () => Evento[],
    required: true,
  },
  urgenciaAtendimentos: {
    type: Array as () => UrgenciaAtendimentoServeSide[],
    required: true,
  },
});

const periodoEspelho = ref({
  isChanged: !(!props.espelho?.periodo_inicio && !props.espelho?.periodo_fim),
  start: props.espelho?.periodo_inicio ? stringToDate(props.espelho.periodo_inicio) : new Date(),
  end: props.espelho?.periodo_fim ? stringToDate(props.espelho.periodo_fim) : new Date(),
});
const grupoDeTodasAsPromotorias = ref<GrupoPromotoria[]>([]);
const dadosDosAtendimentosUrgencia = ref<UrgenciaAtendimentoClientSide[]>([]);
const atribuicao = ref<Atribuicoes[]>([]);
const eventosReativos = ref<Evento[]>(props.eventos);

const updatePeriodoEspelho = (value: any) => {
  periodoEspelho.value.isChanged = true;
  periodoEspelho.value.start = value.start;
  periodoEspelho.value.end = value.end;

  emit('update:periodoEspelho', [format(periodoEspelho.value.start, 'dd/MM/yyyy'), format(periodoEspelho.value.end, 'dd/MM/yyyy')]);
};

const adicionaEventoNoGrupoDePromotorias = (nomeDoGrupoDePromotorias: string, novoEvento: Evento) => {
  grupoDeTodasAsPromotorias.value.forEach((grupoPromotoria) => {
    if (grupoPromotoria.nome_grupo_promotorias === nomeDoGrupoDePromotorias) {
      grupoPromotoria.eventos.push(novoEvento);
    }
  });
  
  emit('update:grupoDeTodasAsPromotorias', grupoDeTodasAsPromotorias.value);
  adicionaAtribuicao(novoEvento);
  adicionaEventoNoArrayReativoDeEventos(novoEvento);
};

const alteraEventoNoGrupoDePromotorias = (eventoAlterado: Evento) => {
  grupoDeTodasAsPromotorias.value.forEach((grupoPromotoria) => {
    grupoPromotoria.eventos.forEach((evento) => {
      if (evento.uuid === eventoAlterado.uuid) {
        evento.tipo = eventoAlterado.tipo;
        evento.periodo_inicio = eventoAlterado.periodo_inicio;
        evento.periodo_fim = eventoAlterado.periodo_fim;
        evento.titulo = eventoAlterado.titulo;
        evento.promotor_designado_id = eventoAlterado.promotor_designado_id;
      }
    });
  });
  emit('update:grupoDeTodasAsPromotorias', grupoDeTodasAsPromotorias.value);
  alteraAtribuicao(eventoAlterado);
  alteraEventoNoArrayReativoDeEventos(eventoAlterado);
};

const deletaEventoNoGrupoDePromotorias = (uuid: string) => {
  grupoDeTodasAsPromotorias.value.forEach((grupoPromotoria) => {
    grupoPromotoria.eventos = grupoPromotoria.eventos.filter((evento) => evento.uuid !== uuid);
  });
  emit('update:grupoDeTodasAsPromotorias', grupoDeTodasAsPromotorias.value)
  deletaAtribuicao(uuid);
  deletaEventoNoArrayReativoDeEventos(uuid);
};

const atualizaPromotorDesignadoParaAtendimentosDeUrgencia = (index: number, idPromotor: string) => {
  if (dadosDosAtendimentosUrgencia.value[index]){
    dadosDosAtendimentosUrgencia.value[index].promotor_designado_id = idPromotor;
  } else {
    dadosDosAtendimentosUrgencia.value.push({
      uuid: uuidv4(),
      periodo_inicio: '',
      periodo_fim: '',
      promotor_designado_id: idPromotor,
    });
  }
  emit('update:dadosDosAtendimentosUrgencia', dadosDosAtendimentosUrgencia.value);
};

const atualizaPeriodoQueOPromotorVaiEstarDesignadoParaAtendimentosDeUrgencia = (index : number, periodo_start: string, periodo_end: string) => {
  if (dadosDosAtendimentosUrgencia.value[index]){
    dadosDosAtendimentosUrgencia.value[index].periodo_inicio = periodo_start;
    dadosDosAtendimentosUrgencia.value[index].periodo_fim = periodo_end;
  } else {
    dadosDosAtendimentosUrgencia.value.push({
      uuid: uuidv4(),
      periodo_inicio: periodo_start,
      periodo_fim: periodo_end,
      promotor_designado_id: '',
    });
  }
  emit('update:dadosDosAtendimentosUrgencia', dadosDosAtendimentosUrgencia.value);
};

const deletaInputDeDadosDeAtendimentoUrgencia = (index: number) => {
  dadosDosAtendimentosUrgencia.value.splice(index, 1);
  emit('update:dadosDosAtendimentosUrgencia', dadosDosAtendimentosUrgencia.value);
};

const adicionaAtribuicao = (evento: Evento) => {
  const nome_promotor = props.promotores.find((promotor) => promotor.id === evento.promotor_designado_id)?.nome || '';
  const index = atribuicao.value.findIndex((a) => a.nome_promotor === nome_promotor);
  if (index === -1) {
    atribuicao.value.push({
      nome_promotor: nome_promotor,
      atribuicoes: [evento],
    });
  } else {
    atribuicao.value[index].atribuicoes.push(evento);
  }
  emit('update:atribuicao', atribuicao.value);
};

const alteraAtribuicao = (evento: Evento) => {
  const nome_promotor = props.promotores.find((promotor) => promotor.id === evento.promotor_designado_id)?.nome || '';
  const index = atribuicao.value.findIndex((a) => a.nome_promotor === nome_promotor);
  if (index !== -1) {
    const eventoIndex = atribuicao.value[index].atribuicoes.findIndex((e) => e.uuid === evento.uuid);
    if (eventoIndex !== -1) {
      atribuicao.value[index].atribuicoes[eventoIndex] = evento;
    }
  }
  emit('update:atribuicao', atribuicao.value);
};

const deletaAtribuicao = (uuid: string) => {
  const evento = atribuicao.value.find((a) => a.atribuicoes.find((e) => e.uuid === uuid));
  if (evento) {
    evento.atribuicoes = evento.atribuicoes.filter((e) => e.uuid !== uuid);
    if (evento.atribuicoes.length === 0) {
      atribuicao.value = atribuicao.value.filter((a) => a !== evento);
    }
  }
  emit('update:atribuicao', atribuicao.value);
};

const adicionaDadosNoGrupoDePromotorias = (grupoPromotorias: GrupoPromotoria[]) => {
  grupoDeTodasAsPromotorias.value = grupoDeTodasAsPromotorias.value.concat(grupoPromotorias);
  emit('update:grupoDeTodasAsPromotorias', grupoDeTodasAsPromotorias.value);
};

const atualizaAsAtribuicoes = (eventos: Evento[]) => {
  eventos.forEach((evento) => {
    if (atribuicao.value.length === 0) {
      atribuicao.value.push({
        nome_promotor: props.promotores.find((promotor) => promotor.id === evento.promotor_designado_id)?.nome || '',
        atribuicoes: evento ? [evento] : [],
      })
    } else {
      const index = atribuicao.value.findIndex((a) => a.nome_promotor === props.promotores.find((promotor) => promotor.id === evento.promotor_designado_id)?.nome);
      if (index === -1) {
        atribuicao.value.push({
          nome_promotor: props.promotores.find((promotor) => promotor.id === evento.promotor_designado_id)?.nome || '',
          atribuicoes: evento ? [evento] : [],
        });
      } else {
        atribuicao.value[index].atribuicoes.push(evento);
      }
    }
  });
  emit('update:atribuicao', atribuicao.value);
}

const adicionaEventoNoArrayReativoDeEventos = (evento: Evento) => {
  eventosReativos.value.push(evento);
  emit('update:ListaEventos', eventosReativos.value);
};

const alteraEventoNoArrayReativoDeEventos = (evento: Evento) => {
  const index = eventosReativos.value.findIndex((e) => e.uuid === evento.uuid);
  if (index !== -1) {
    eventosReativos.value[index] = evento;
  }
  emit('update:ListaEventos', eventosReativos.value);
};

const deletaEventoNoArrayReativoDeEventos = (uuid: string) => {
  eventosReativos.value = eventosReativos.value.filter((evento) => evento.uuid !== uuid);
  emit('update:ListaEventos', eventosReativos.value);
};

function stringToDate(dateString: string) {
  const [year, month, day] = dateString.split('-').map(Number);
  return new Date(year, month - 1, day);
}

onBeforeMount(() => {
  props.urgenciaAtendimentos?.forEach((atendimentoUrgencia) => {
    dadosDosAtendimentosUrgencia.value.push({
      uuid: atendimentoUrgencia.id,
      periodo_inicio: atendimentoUrgencia.periodo_inicio,
      periodo_fim: atendimentoUrgencia.periodo_fim,
      promotor_designado_id: atendimentoUrgencia.promotor_designado_id,
    });
  });
  atualizaAsAtribuicoes(props.eventos);
});
</script>

<template>
  <Card>
      <div class="max-w-5xl mx-auto">
      <CardHeader class="flex flex-row items-center justify-between">
        <CardTitle class="font-semibold">
          Espelho do Ministério Público
        </CardTitle>
        <span class="flex items-center">
          <Label for="period" class="text-base mr-4">
            Período:
          </Label>
          <DatePicker
            :period_start="periodoEspelho.start"
            :period_end="periodoEspelho.end"
            :wasChanged="periodoEspelho.isChanged"
            :range="true"
            @update:period="updatePeriodoEspelho"
          />
        </span>
      </CardHeader>

      <CardContent>
        <EntranciaFinalMacapaEditor
          :promotoriasMacapa="props.promotorias?.filter((promotoria) => promotoria.municipio === 'Macapá')"
          :eventos="props.eventos"
          :promotores="props.promotores"
          :urgenciaAtendimentos="props.urgenciaAtendimentos"
          @update:novoEventoAdicionado="adicionaEventoNoGrupoDePromotorias"
          @update:umEventoFoiAlterado="alteraEventoNoGrupoDePromotorias"
          @delete:umEventoFoiDeletado="deletaEventoNoGrupoDePromotorias"
          @update:nomeFoiSelecionado="atualizaPromotorDesignadoParaAtendimentosDeUrgencia"
          @update:periodoDoAtendimentoFoiSelecionado="atualizaPeriodoQueOPromotorVaiEstarDesignadoParaAtendimentosDeUrgencia"
          @delete:inputDeDadosFoiDeletado="deletaInputDeDadosDeAtendimentoUrgencia"
          @update:grupoPromotorias="adicionaDadosNoGrupoDePromotorias"

        />
        <EntranciaFinalSantanaEditor
          :promotoriasSantana="props.promotorias?.filter((promotoria) => promotoria.municipio === 'Santana')"
          :eventos="props.eventos"
          :promotores="props.promotores"
          @update:novoEventoAdicionado="adicionaEventoNoGrupoDePromotorias"
          @update:umEventoFoiAlterado="alteraEventoNoGrupoDePromotorias"
          @delete:umEventoFoiDeletado="deletaEventoNoGrupoDePromotorias"
          @update:grupoPromotorias="adicionaDadosNoGrupoDePromotorias"
        />
        <EntranciaInicialEditor
          :promotoriasInterior="props.promotorias?.filter((promotoria) => promotoria.municipio !== 'Macapá' && promotoria.municipio !== 'Santana')"
          :eventos="props.eventos"
          :promotores="props.promotores"
          @update:novoEventoAdicionado="adicionaEventoNoGrupoDePromotorias"
          @update:umEventoFoiAlterado="alteraEventoNoGrupoDePromotorias"
          @delete:umEventoFoiDeletado="deletaEventoNoGrupoDePromotorias"
          @update:grupoPromotorias="adicionaDadosNoGrupoDePromotorias"
        />
      </CardContent>
    </div>
  </Card>
</template>
