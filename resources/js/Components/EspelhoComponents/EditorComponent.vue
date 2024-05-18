<script setup lang="ts">
import {ref, onBeforeMount} from 'vue';
import {v4 as uuidv4} from 'uuid';
import {format} from 'date-fns';
import {Espelho} from "@/Interfaces/Espelho/Espelho";
import {Promotor} from "@/Interfaces/Promotor/Promotor";
import {Promotoria} from "@/Interfaces/Promotoria/Promotoria";
import {UrgenciaAtendimento} from "@/Interfaces/UrgenciaAtendimento";
import {GrupoPromotoria} from "@/Interfaces/GrupoPromotoria";
import {Atribuicoes} from "@/Interfaces/Atribuicoes";
import {Evento} from "@/Interfaces/Evento";

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
    grupoPromotorias: {
        type: Array as () => GrupoPromotoria[],
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
const grupoDeTodasAsPromotorias = ref<GrupoPromotoria[]>(props.grupoPromotorias);
const dadosDosAtendimentosUrgencia = ref<UrgenciaAtendimento[]>([]);
const atribuicao = ref<Atribuicoes[]>([]);
const eventosReativos = ref<Evento[]>(props.eventos);

const updatePeriodoEspelho = (value: any) => {
    periodoEspelho.value.isChanged = true;
    periodoEspelho.value.start = value.start;
    periodoEspelho.value.end = value.end;

    emit('update:periodoEspelho', [format(periodoEspelho.value.start, 'dd/MM/yyyy'), format(periodoEspelho.value.end, 'dd/MM/yyyy')]);
};

const adicionaEventoNoGrupoDePromotorias = (grupoDePromotoriaID: String, promotoriaID: String, novoEvento: Evento) => {
    grupoDeTodasAsPromotorias.value.find((grupoPromotoria) =>
        grupoPromotoria.id === grupoDePromotoriaID)?.promotorias?.find((promotoria) =>
        promotoria.id === promotoriaID)?.promotor?.eventos?.push(novoEvento);

    emit('update:grupoDeTodasAsPromotorias', grupoDeTodasAsPromotorias.value);
    adicionaAtribuicao(novoEvento);
    adicionaEventoNoArrayReativoDeEventos(novoEvento);
};

const alteraEventoNoGrupoDePromotorias =(grupoDePromotoriaID: String, promotoriaID: String, eventoAlterado: Evento) => {
    grupoDeTodasAsPromotorias.value.find((grupoPromotoria) =>
        grupoPromotoria.id === grupoDePromotoriaID)?.promotorias?.find((promotoria) =>
        promotoria.id === promotoriaID)?.promotor?.eventos?.forEach((evento) => {
            if (evento.uuid === eventoAlterado.uuid && evento.uuid !== undefined) {
                evento.id = eventoAlterado.id;
                evento.uuid = eventoAlterado.uuid;
                evento.titulo = eventoAlterado.titulo;
                evento.tipo = eventoAlterado.tipo;
                evento.periodo_inicio = eventoAlterado.periodo_inicio;
                evento.periodo_fim = eventoAlterado.periodo_fim;
                evento.promotor_designado_id = eventoAlterado.promotor_designado_id;
                return evento;
            }
            if (evento.id === eventoAlterado.id && evento.id !== undefined) {
                evento.id = eventoAlterado.id;
                evento.uuid = eventoAlterado.uuid;
                evento.titulo = eventoAlterado.titulo;
                evento.tipo = eventoAlterado.tipo;
                evento.periodo_inicio = eventoAlterado.periodo_inicio;
                evento.periodo_fim = eventoAlterado.periodo_fim;
                evento.promotor_designado_id = eventoAlterado.promotor_designado_id;
                return evento;
            }
            return evento;
        });
    emit('update:grupoDeTodasAsPromotorias', grupoDeTodasAsPromotorias.value);
    alteraAtribuicao(eventoAlterado);
    alteraEventoNoArrayReativoDeEventos(eventoAlterado);
};

const deletaEventoNoGrupoDePromotorias = (eventoDeletado: Evento) => {
    grupoDeTodasAsPromotorias.value.forEach((grupoPromotoria) => {
        grupoPromotoria.promotorias?.forEach((promotoria) => {
          if (promotoria.promotor_titular_id === eventoDeletado.promotor_titular_id) {
            promotoria.promotor?.eventos?.splice(promotoria.promotor?.eventos?.indexOf(eventoDeletado), 1);
          }
        });
    });
    emit('update:grupoDeTodasAsPromotorias', grupoDeTodasAsPromotorias.value)
    deletaAtribuicao(eventoDeletado);
    deletaEventoNoArrayReativoDeEventos(eventoDeletado);
};

const atualizaPromotorDesignadoParaAtendimentosDeUrgencia = (index: number, idPromotor: string) => {
    if (dadosDosAtendimentosUrgencia.value[index]) {
        dadosDosAtendimentosUrgencia.value[index].promotor_designado_id = idPromotor;
    } else {
        dadosDosAtendimentosUrgencia.value.push({
            id: '',
            uuid: uuidv4(),
            periodo_inicio: '',
            periodo_fim: '',
            promotor_designado_id: idPromotor,
            created_at: '',
            updated_at: '',
        });
    }
    emit('update:dadosDosAtendimentosUrgencia', dadosDosAtendimentosUrgencia.value);
};

const atualizaPeriodoQueOPromotorVaiEstarDesignadoParaAtendimentosDeUrgencia = (index: number, periodo_start: string, periodo_end: string) => {
    if (dadosDosAtendimentosUrgencia.value[index]) {
        dadosDosAtendimentosUrgencia.value[index].periodo_inicio = periodo_start;
        dadosDosAtendimentosUrgencia.value[index].periodo_fim = periodo_end;
    } else {
        dadosDosAtendimentosUrgencia.value.push({
            id: '',
            uuid: uuidv4(),
            periodo_inicio: periodo_start,
            periodo_fim: periodo_end,
            promotor_designado_id: '',
            created_at: '',
            updated_at: '',
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

const deletaAtribuicao = (eventoDeletado: Evento) => {
    const eventoBuscaPorUuid = atribuicao.value.find((a) => a.atribuicoes.find((e) => e.uuid === eventoDeletado.uuid));
    if (eventoBuscaPorUuid) {
        eventoBuscaPorUuid.atribuicoes = eventoBuscaPorUuid.atribuicoes.filter((e) => e.uuid !== eventoDeletado.uuid);
        if (eventoBuscaPorUuid.atribuicoes.length === 0) {
            atribuicao.value = atribuicao.value.filter((a) => a !== eventoBuscaPorUuid);
        }
    } else {
        const eventoBuscaPorId = atribuicao.value.find((a) => a.atribuicoes.find((e) => e.id === eventoDeletado.id));
        if (eventoBuscaPorId) {
            eventoBuscaPorId.atribuicoes = eventoBuscaPorId.atribuicoes.filter((e) => e.id !== eventoDeletado.id);
            if (eventoBuscaPorId.atribuicoes.length === 0) {
                atribuicao.value = atribuicao.value.filter((a) => a !== eventoBuscaPorId);
            }
        }
    }
    emit('update:atribuicao', atribuicao.value);
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
    if (evento.uuid !== undefined){
        const index = eventosReativos.value.findIndex((e) => e.uuid === evento.uuid);
        if (index !== -1) {
            eventosReativos.value[index] = evento;
        }
    }
    if (evento.id !== undefined){
        const index = eventosReativos.value.findIndex((e) => e.id === evento.id);
        if (index !== -1) {
            eventosReativos.value[index] = evento;
        }
    }
    emit('update:ListaEventos', eventosReativos.value);
};

const deletaEventoNoArrayReativoDeEventos = (eventoDeletado: Evento) => {
    eventosReativos.value = eventosReativos.value.filter((evento) => evento.uuid !== eventoDeletado.uuid || evento.id !== eventoDeletado.id);
    emit('update:ListaEventos', eventosReativos.value);
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
            created_at: atendimentoUrgencia.created_at,
            updated_at: atendimentoUrgencia.updated_at,
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
                    :grupoPromotorias="grupoPromotorias?.filter((grupoPromotoria) => grupoPromotoria.municipio?.nome === 'Macapá')"
                    :promotorias="props.promotorias?.filter((promotoria) => promotoria.grupo_promotoria?.municipio?.nome === 'Macapá')"
                    :promotores="props.promotores"
                    :urgenciaAtendimentos="props.urgenciaAtendimentos"
                    @update:novoEventoAdicionado="adicionaEventoNoGrupoDePromotorias"
                    @update:umEventoFoiAlterado="alteraEventoNoGrupoDePromotorias"
                    @delete:umEventoFoiDeletado="deletaEventoNoGrupoDePromotorias"
                    @update:nomeFoiSelecionado="atualizaPromotorDesignadoParaAtendimentosDeUrgencia"
                    @update:periodoDoAtendimentoFoiSelecionado="atualizaPeriodoQueOPromotorVaiEstarDesignadoParaAtendimentosDeUrgencia"
                    @delete:inputDeDadosFoiDeletado="deletaInputDeDadosDeAtendimentoUrgencia"

                />
                <EntranciaFinalSantanaEditor
                    :grupoPromotorias="grupoPromotorias?.filter((grupoPromotoria) => grupoPromotoria.municipio?.nome === 'Santana')"
                    :promotorias="props.promotorias?.filter((promotoria) => promotoria.grupo_promotoria?.municipio?.nome === 'Santana')"
                    :promotores="props.promotores"
                    @update:novoEventoAdicionado="adicionaEventoNoGrupoDePromotorias"
                    @update:umEventoFoiAlterado="alteraEventoNoGrupoDePromotorias"
                    @delete:umEventoFoiDeletado="deletaEventoNoGrupoDePromotorias"
                />
                <EntranciaInicialEditor
                    :grupoPromotorias="grupoPromotorias?.filter((grupoPromotoria) => grupoPromotoria.municipio?.nome !== 'Macapá' && grupoPromotoria.municipio?.nome !== 'Santana')"
                    :promotorias="props.promotorias?.filter((promotoria) => promotoria.grupo_promotoria?.municipio?.nome !== 'Macapá' && promotoria.grupo_promotoria?.municipio?.nome !== 'Santana')"
                    :promotores="props.promotores"
                    @update:novoEventoAdicionado="adicionaEventoNoGrupoDePromotorias"
                    @update:umEventoFoiAlterado="alteraEventoNoGrupoDePromotorias"
                    @delete:umEventoFoiDeletado="deletaEventoNoGrupoDePromotorias"
                />
            </CardContent>
        </div>
    </Card>
</template>
