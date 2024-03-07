<script setup lang="ts">
import {
  Promotoria,
  GrupoPromotoria,
  Espelho,
  Promotor,
  Evento,
  UrgenciaAtendimento, Atribuicoes
} from '@/types';
import { ref, onBeforeMount, onMounted } from 'vue';

import { Label } from '@/Components/ui/label';
import DatePicker from '@/Components/DatePicker.vue';
import { Card, CardContent, CardHeader, CardTitle } from '@/Components/ui/card';

import { format } from 'date-fns';
import EntranciaFinalMacapaEditor from './EditorComponents/EntranciaFinalMacapaEditor.vue';
import EntranciaFinalSantanaEditor from './EditorComponents/EntranciaFinalSantanaEditor.vue';
import EntranciaInicialEditor from './EditorComponents/EntranciaInicialEditor.vue';
import { useForm } from "@inertiajs/vue3";

const emit = defineEmits([
  'update:periodoEspelho',
  'update:grupoDeTodasAsPromotorias',
  'update:dadosDosAtendimentosUrgencia',
  'update:atribuicao',
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
    type: Array as () => UrgenciaAtendimento[],
    required: true,
  },
});

const periodoEspelho = ref({
  isChanged: !(!props.espelho?.periodo_inicio && !props.espelho?.periodo_fim),
  start: props.espelho?.periodo_inicio ? stringToDate(props.espelho.periodo_inicio) : new Date(),
  end: props.espelho?.periodo_fim ? stringToDate(props.espelho.periodo_fim) : new Date(),
});
const grupoDeTodasAsPromotorias = ref<GrupoPromotoria[]>([]);
const dadosDosAtendimentosUrgencia = ref<UrgenciaAtendimento[]>([]);
const atribuicao = ref<Atribuicoes[]>([]);

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
};

const alteraEventoNoGrupoDePromotorias = (eventoAlterado: Evento) => {
  grupoDeTodasAsPromotorias.value.forEach((grupoPromotoria) => {
    grupoPromotoria.eventos.forEach((evento) => {
      if (evento.id === eventoAlterado.id) {
        evento.id = eventoAlterado.id;
        evento.tipo = eventoAlterado.tipo;
        evento.periodo_inicio = eventoAlterado.periodo_inicio;
        evento.periodo_fim = eventoAlterado.periodo_fim;
        evento.titulo = eventoAlterado.titulo;
        evento.promotor_designado_id = eventoAlterado.promotor_designado_id;
      }
    });
  });
  emit('update:grupoDeTodasAsPromotorias', grupoDeTodasAsPromotorias.value);
};

const deletaEventoNoGrupoDePromotorias = (eventoId: string) => {
  grupoDeTodasAsPromotorias.value.forEach((grupoPromotoria) => {
    grupoPromotoria.eventos = grupoPromotoria.eventos.filter((evento) => evento.id !== eventoId);
  });
  emit('update:grupoDeTodasAsPromotorias', grupoDeTodasAsPromotorias.value)
};

const atualizaPromotorDesignadoParaAtendimentosDeUrgencia = (index: number, idPromotor: string) => {
  if (dadosDosAtendimentosUrgencia.value[index]){
    dadosDosAtendimentosUrgencia.value[index].promotor_designado_id = idPromotor;
  } else {
    dadosDosAtendimentosUrgencia.value.push({
      id: '1',
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
      id: '1',
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

function stringToDate(dateString: string) {
  const [year, month, day] = dateString.split('-').map(Number);
  return new Date(year, month - 1, day);
}

onBeforeMount(() => {
  props.urgenciaAtendimentos?.forEach((atendimentoUrgencia) => {
    dadosDosAtendimentosUrgencia.value.push({
      id: atendimentoUrgencia.id,
      periodo_inicio: atendimentoUrgencia.periodo_inicio,
      periodo_fim: atendimentoUrgencia.periodo_fim,
      promotor_designado_id: atendimentoUrgencia.promotor_designado_id,
    });
  });
  emit('update:dadosDosAtendimentosUrgencia', dadosDosAtendimentosUrgencia.value);

  props.eventos?.forEach((evento) => {
    if (atribuicao.value.length === 0) {
      atribuicao.value.push({
        nome_promotor: props.promotores.find((promotor) => promotor.id === evento.promotor_designado_id)?.nome || '',
        atribuicoes: [
          {
            id: evento.id,
            titulo: evento.titulo,
            tipo: evento.tipo,
            periodo_inicio: evento.periodo_inicio,
            periodo_fim: evento.periodo_fim,
            promotor_designado_id: evento.promotor_designado_id,
            promotor_titular_id: evento.promotor_titular_id,
          },
        ],
      })
    } else {
      const index = atribuicao.value.findIndex((a) => a.nome_promotor === props.promotores.find((promotor) => promotor.id === evento.promotor_designado_id)?.nome);
      if (index === -1) {
        atribuicao.value.push({
          nome_promotor: props.promotores.find((promotor) => promotor.id === evento.promotor_designado_id)?.nome || '',
          atribuicoes: [
            {
              id: evento.id,
              titulo: evento.titulo,
              tipo: evento.tipo,
              periodo_inicio: evento.periodo_inicio,
              periodo_fim: evento.periodo_fim,
              promotor_designado_id: evento.promotor_designado_id,
              promotor_titular_id: evento.promotor_titular_id,
            },
          ],
        });
      } else {
        const indexAtribuicao = atribuicao.value[index].atribuicoes.findIndex((a) => a.id === evento.id);
        if (indexAtribuicao === -1) {
          atribuicao.value[index].atribuicoes.push({
            id: evento.id,
            titulo: evento.titulo,
            tipo: evento.tipo,
            periodo_inicio: evento.periodo_inicio,
            periodo_fim: evento.periodo_fim,
            promotor_designado_id: evento.promotor_designado_id,
            promotor_titular_id: evento.promotor_titular_id,
          });
        }
      }
    }
  });

  emit('update:atribuicao', atribuicao.value);
});

onMounted(() => {
  //console.log(periodoEspelho.value);
  
});

const form = useForm({

})
</script>

<template>
  <Card>
<!--    <form>-->
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
          :promotores="props.promotores"
          :urgenciaAtendimentos="props.urgenciaAtendimentos"
          @update:novoEventoAdicionado="adicionaEventoNoGrupoDePromotorias"
          @update:UmEventoFoiAlterado="alteraEventoNoGrupoDePromotorias"
          @delete:umEventoFoiDeletado="deletaEventoNoGrupoDePromotorias"
          @update:nomeFoiSelecionado="atualizaPromotorDesignadoParaAtendimentosDeUrgencia"
          @update:periodoDoAtendimentoFoiSelecionado="atualizaPeriodoQueOPromotorVaiEstarDesignadoParaAtendimentosDeUrgencia"
          @delete:inputDeDadosFoiDeletado="deletaInputDeDadosDeAtendimentoUrgencia"
        />
        <EntranciaFinalSantanaEditor
          :promotoriasSantana="props.promotorias?.filter((promotoria) => promotoria.municipio === 'Santana')"
          :promotores="props.promotores"
          @update:novoEventoAdicionado="adicionaEventoNoGrupoDePromotorias"
          @update:UmEventoFoiAlterado="alteraEventoNoGrupoDePromotorias"
          @delete:umEventoFoiDeletado="deletaEventoNoGrupoDePromotorias"
        />
        <EntranciaInicialEditor
          :promotoriasInterior="props.promotorias?.filter((promotoria) => promotoria.municipio !== 'Macapá' && promotoria.municipio !== 'Santana')"
          :promotores="props.promotores"
          @update:novoEventoAdicionado="adicionaEventoNoGrupoDePromotorias"
          @update:UmEventoFoiAlterado="alteraEventoNoGrupoDePromotorias"
          @delete:umEventoFoiDeletado="deletaEventoNoGrupoDePromotorias"
        />
      </CardContent>
    </div>
<!--    </form>-->
  </Card>
</template>
