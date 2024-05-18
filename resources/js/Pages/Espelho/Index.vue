<script setup lang="ts">
import {Head} from '@inertiajs/vue3';
import {format} from 'date-fns';
import {watchEffect, ref, onBeforeMount} from 'vue';
import {HistoricoPromotoria} from "@/Interfaces/Historico/HistoricoPromotoria";
import {Promotor} from "@/Interfaces/Promotor/Promotor";
import {HistoricoEvento} from "@/Interfaces/Historico/HistoricoEvento";
import {HistoricoUrgenciaAtendimento} from "@/Interfaces/Historico/HistoricoUrgenciaAtendimento";
import {GrupoPromotoria} from "@/Interfaces/GrupoPromotoria";
import {Atribuicoes} from "@/Interfaces/Atribuicoes";
import {Evento} from "@/Interfaces/Evento";
import {UrgenciaAtendimento} from "@/Interfaces/UrgenciaAtendimento";
import {HistoricoEspelho} from "@/Interfaces/Historico/HistoricoEspelho";
import {HistoricoGrupoPromotoria} from "@/Interfaces/Historico/HistoricoGrupoPromotoria";
import {Promotoria} from "@/Interfaces/Promotoria/Promotoria";

const props = defineProps({
    historicoEspelho: {
        type: Object as () => HistoricoEspelho,
        required: true,
    },
    historicoGrupoPromotorias: {
        type: Array as () => HistoricoGrupoPromotoria[],
        required: true,
    },
    historicoPromotorias: {
        type: Array as () => HistoricoPromotoria[],
        required: true,
    },
    historicoPromotores: {
        type: Array as () => Promotor[],
        required: true,
    },
    historicoEventos: {
        type: Array as () => HistoricoEvento[],
        required: true,
    },
    historicoUrgenciaAtendimentos: {
        type: Array as () => HistoricoUrgenciaAtendimento[],
        required: true,
    },
});

const grupoDeTodasAsPromotoriasDados = ref<GrupoPromotoria[]>([]);
const periodoEspelho = ref<string[]>([
    format(stringToDate(props.historicoEspelho?.periodo_inicio), 'dd/MM/yyyy'),
    format(stringToDate(props.historicoEspelho?.periodo_fim), 'dd/MM/yyyy'),
]);
const atendimentosUrgenciaDados = ref<UrgenciaAtendimento[]>([]);
const eventos = ref<Evento[]>([]);
const listaAtribuicoes = ref<Atribuicoes[]>([]);

const processaGrupoDeTodasAsPromotoriasDados = (grupoPromotorias: HistoricoGrupoPromotoria[]) => {
    grupoPromotorias.forEach((grupoPromotoria) => {
        grupoDeTodasAsPromotoriasDados.value.push({
            id: grupoPromotoria.id,
            nome: grupoPromotoria.nome,
            municipio_id: grupoPromotoria.historico_municipio_id,
            created_at: grupoPromotoria.created_at,
            updated_at: grupoPromotoria.updated_at,
            promotorias: grupoPromotoria.promotorias?.map((promotoria) => {
                let mappedPromotoria: Promotoria = {
                    id: promotoria.id,
                    nome: promotoria.nome,
                    is_especializada: promotoria.is_especializada,
                    espelho_id: promotoria.historico_espelho_id,
                    promotor_titular_id: promotoria.historico_promotor_titular_id,
                    grupo_promotoria_id: promotoria.historico_grupo_promotoria_id,
                    created_at: promotoria.created_at,
                    updated_at: promotoria.updated_at,
                };

                if (promotoria.promotor) {
                    mappedPromotoria.promotor = {
                        id: promotoria.promotor.id,
                        nome: promotoria.promotor.nome,
                        is_substituto: promotoria.promotor.is_substituto,
                        created_at: promotoria.promotor.created_at,
                        updated_at: promotoria.promotor.updated_at,
                        eventos: promotoria.promotor.eventos?.map((evento) => {
                            return {
                                id: evento.id,
                                titulo: evento.titulo,
                                tipo: evento.tipo,
                                periodo_inicio: evento.periodo_inicio,
                                periodo_fim: evento.periodo_fim,
                                promotor_titular_id: evento.historico_promotor_titular_id,
                                promotor_designado_id: evento.historico_promotor_designado_id,
                            }
                        }),
                    }
                }

                return mappedPromotoria;
            }),
            municipio: {
                id: grupoPromotoria.municipio?.id ? grupoPromotoria.municipio.id : '',
                nome: grupoPromotoria.municipio?.nome ? grupoPromotoria.municipio.nome : '',
                created_at: grupoPromotoria.municipio?.created_at ? grupoPromotoria.municipio.created_at : '',
                updated_at: grupoPromotoria.municipio?.updated_at ? grupoPromotoria.municipio.updated_at : '',
            }
        });
    });
}

const processaEventos = (eventos: HistoricoEvento[]) => {
    return eventos.map(evento => ({
        id: evento.id,
        uuid: evento.uuid,
        titulo: evento.titulo ? evento.titulo : '',
        tipo: evento.tipo,
        periodo_inicio: evento.periodo_inicio,
        periodo_fim: evento.periodo_fim,
        promotor_titular_id: evento.historico_promotor_titular_id,
        promotor_designado_id: evento.historico_promotor_designado_id,
    }))
}

const atualizaAsAtribuicoes = (eventos: Evento[]) => {
    eventos.forEach((evento) => {
        if (listaAtribuicoes.value.length === 0) {
            listaAtribuicoes.value.push({
                nome_promotor: props.historicoPromotores.find((promotor) => promotor.id === evento.promotor_designado_id)?.nome || '',
                atribuicoes: evento ? [evento] : [],
            })
        } else {
            const index = listaAtribuicoes.value.findIndex((a) => a.nome_promotor === props.historicoPromotores.find((promotor) => promotor.id === evento.promotor_designado_id)?.nome);
            if (index === -1) {
                listaAtribuicoes.value.push({
                    nome_promotor: props.historicoPromotores.find((promotor) => promotor.id === evento.promotor_designado_id)?.nome || '',
                    atribuicoes: evento ? [evento] : [],
                });
            } else {
                listaAtribuicoes.value[index].atribuicoes.push(evento);
            }
        }
    });
}

const processaAtendimentosUrgenciaDados = (urgenciaAtendimentos: HistoricoUrgenciaAtendimento[]) => {
    urgenciaAtendimentos?.forEach((atendimentoUrgencia) => {
        atendimentosUrgenciaDados.value.push({
            id: atendimentoUrgencia.id,
            periodo_inicio: atendimentoUrgencia.periodo_inicio,
            periodo_fim: atendimentoUrgencia.periodo_fim,
            promotor_designado_id: atendimentoUrgencia.historico_promotor_designado_id,
            created_at: atendimentoUrgencia.created_at,
            updated_at: atendimentoUrgencia.updated_at,
            promotor: {
                id: atendimentoUrgencia.promotor?.id ? atendimentoUrgencia.promotor.id : '',
                nome: atendimentoUrgencia.promotor?.nome ? atendimentoUrgencia.promotor.nome : '',
                is_substituto: atendimentoUrgencia.promotor?.is_substituto ? atendimentoUrgencia.promotor.is_substituto : false,
                created_at: atendimentoUrgencia.promotor?.created_at ? atendimentoUrgencia.promotor.created_at : '',
                updated_at: atendimentoUrgencia.promotor?.updated_at ? atendimentoUrgencia.promotor.updated_at : '',
            },
        });
    });
}

function stringToDate(dateString: string) {
    const [year, month, day] = dateString.split('-').map(Number);
    return new Date(year, month - 1, day);
}

watchEffect(() => {
    processaGrupoDeTodasAsPromotoriasDados(props.historicoGrupoPromotorias);
    eventos.value = processaEventos(props.historicoEventos);
    atualizaAsAtribuicoes(eventos.value);
    processaAtendimentosUrgenciaDados(props.historicoUrgenciaAtendimentos);
});

</script>

<template>
    <Head title="Espelho"/>
    <Preview
        :periodoEspelho="periodoEspelho"
        :grupoPromotoriaDeTodasAsPromotorias="grupoDeTodasAsPromotoriasDados"
        :listaAtribuicoes="listaAtribuicoes"
        :atendimentosUrgenciaDados="atendimentosUrgenciaDados"
    />
</template>
