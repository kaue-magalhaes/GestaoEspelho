<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { format } from 'date-fns';
import { watchEffect, ref } from 'vue';
import {Espelho} from "@/Interfaces/Espelho";
import {HistoricoPromotoria} from "@/Interfaces/Historico/HistoricoPromotoria";
import {Promotor} from "@/Interfaces/Promotor";
import {HistoricoEventoServerSide} from "@/Interfaces/Historico/HistoricoEvento";
import {HistoricoUrgenciaAtendimentoServeSide} from "@/Interfaces/Historico/HistoricoUrgenciaAtendimento";
import {GrupoPromotoria} from "@/Interfaces/GrupoPromotoria";
import {Atribuicoes} from "@/Interfaces/Atribuicoes";
import {Evento} from "@/Interfaces/Evento";

const props = defineProps({
    espelho: {
        type: Object as () => Espelho,
        required: true,
    },
    promotorias: {
        type: Array as () => HistoricoPromotoria[],
        required: true,
    },
    promotores: {
        type: Array as () => Promotor[],
        required: true,
    },
    eventos: {
        type: Array as () => HistoricoEventoServerSide[],
        required: true,
    },
    urgenciaAtendimentos: {
        type: Array as () => HistoricoUrgenciaAtendimentoServeSide[],
        required: true,
    },
});

const grupoDeTodasAsPromotoriasDados = ref<GrupoPromotoria[]>([]);
const grupoDePromotoriasDados = ref<GrupoPromotoria[]>([]);
const promotoriasMacapa = ref<HistoricoPromotoria[]>([]);
const promotoriasSantana = ref<HistoricoPromotoria[]>([]);
const promotoriasInterior = ref<HistoricoPromotoria[]>([]);
const periodoEspelhoFormatado = ref<string[]>([]);
const listaAtribuicoes = ref<Atribuicoes[]>([]);
const atendimentosUrgenciaDados = ref<any>([]);
const eventosComUUID = ref<Evento[]>([]);

const separaPromotoriasPorMunicipio = (promotoria: HistoricoPromotoria) => {
    if (promotoria.municipio === 'Macapá') {
        promotoriasMacapa.value.push(promotoria);
    } else if (promotoria.municipio === 'Santana') {
        promotoriasSantana.value.push(promotoria);
    } else {
        promotoriasInterior.value.push(promotoria);
    }
};

const processarPromotorias = (promotorias: HistoricoPromotoria[]) => {
    promotorias.forEach((promotoria) => {
        if (grupoDePromotoriasDados.value.length === 0) {
            grupoDePromotoriasDados.value.push({
                nome_grupo_promotorias: promotoria.nome_grupo_promotorias,
                promotorias: [{
                    id: promotoria.id,
                    nome: promotoria.nome,
                    nome_grupo_promotorias: promotoria.nome_grupo_promotorias,
                    municipio: promotoria.municipio,
                    is_especializada: promotoria.is_especializada,
                    espelho_id: promotoria.historico_espelho_id,
                    promotor_titular_id: promotoria.historico_promotor_titular_id,
                    created_at: promotoria.created_at,
                    updated_at: promotoria.updated_at,
                }],
                eventos: eventosComUUID.value.filter((evento) => evento.promotor_titular_id === promotoria.historico_promotor_titular_id) || [],
            });
        } else {
            const grupoPromotoria = grupoDePromotoriasDados.value.find((grupoPromotoria) => grupoPromotoria.nome_grupo_promotorias === promotoria.nome_grupo_promotorias);
            if (grupoPromotoria) {
                grupoPromotoria.promotorias.push({
                    id: promotoria.id,
                    nome: promotoria.nome,
                    nome_grupo_promotorias: promotoria.nome_grupo_promotorias,
                    municipio: promotoria.municipio,
                    is_especializada: promotoria.is_especializada,
                    espelho_id: promotoria.historico_espelho_id,
                    promotor_titular_id: promotoria.historico_promotor_titular_id,
                    created_at: promotoria.created_at,
                    updated_at: promotoria.updated_at,
                });
                const novosEventos = eventosComUUID.value.filter((evento) => evento.promotor_titular_id === promotoria.historico_promotor_titular_id);
                novosEventos.forEach((novoEvento) => {
                    const eventoExiste = grupoPromotoria.eventos.some((eventoExistente) => eventoExistente.uuid === novoEvento.uuid);
                    if (!eventoExiste) {
                        grupoPromotoria.eventos.push(novoEvento);
                    }
                });
            } else {
                grupoDePromotoriasDados.value.push({
                    nome_grupo_promotorias: promotoria.nome_grupo_promotorias,
                    promotorias: [{
                        id: promotoria.id,
                        nome: promotoria.nome,
                        nome_grupo_promotorias: promotoria.nome_grupo_promotorias,
                        municipio: promotoria.municipio,
                        is_especializada: promotoria.is_especializada,
                        espelho_id: promotoria.historico_espelho_id,
                        promotor_titular_id: promotoria.historico_promotor_titular_id,
                        created_at: promotoria.created_at,
                        updated_at: promotoria.updated_at,
                    }],
                    eventos: eventosComUUID.value.filter((evento) => evento.promotor_titular_id === promotoria.historico_promotor_titular_id) || [],
                });
            }
        }
    });
    adicionaDadosNoGrupoDePromotorias(grupoDePromotoriasDados.value);
    grupoDePromotoriasDados.value = [];
};

const adicionaDadosNoGrupoDePromotorias = (grupoPromotorias: GrupoPromotoria[]) => {
    grupoDeTodasAsPromotoriasDados.value = grupoDeTodasAsPromotoriasDados.value.concat(grupoPromotorias);
};

const atualizaAsAtribuicoes = (eventos: Evento[]) => {
  eventos.forEach((evento) => {
    if (listaAtribuicoes.value.length === 0) {
      listaAtribuicoes.value.push({
        nome_promotor: props.promotores.find((promotor) => promotor.id === evento.promotor_designado_id)?.nome || '',
        atribuicoes: evento ? [evento] : [],
      })
    } else {
      const index = listaAtribuicoes.value.findIndex((a) => a.nome_promotor === props.promotores.find((promotor) => promotor.id === evento.promotor_designado_id)?.nome);
      if (index === -1) {
        listaAtribuicoes.value.push({
          nome_promotor: props.promotores.find((promotor) => promotor.id === evento.promotor_designado_id)?.nome || '',
          atribuicoes: evento ? [evento] : [],
        });
      } else {
        listaAtribuicoes.value[index].atribuicoes.push(evento);
      }
    }
  });
}

const processaAtendimentosUrgenciaDados = (urgenciaAtendimentos: HistoricoUrgenciaAtendimentoServeSide[]) => {
    urgenciaAtendimentos?.forEach((atendimentoUrgencia) => {
        atendimentosUrgenciaDados.value.push({
        uuid: atendimentoUrgencia.id,
        periodo_inicio: atendimentoUrgencia.periodo_inicio,
        periodo_fim: atendimentoUrgencia.periodo_fim,
        promotor_designado_id: atendimentoUrgencia.historico_promotor_designado_id,
        });
    });
}
const processaEventos = (eventos: HistoricoEventoServerSide[]) => {
    return eventos.map(evento => ({
        uuid: evento.id,
        titulo: evento.titulo,
        tipo: evento.tipo,
        periodo_inicio: evento.periodo_inicio,
        periodo_fim: evento.periodo_fim,
        promotor_titular_id: evento.historico_promotor_titular_id,
        promotor_designado_id: evento.historico_promotor_designado_id,
    }));
};

function stringToDate(dateString: string) {
    const [year, month, day] = dateString.split('-').map(Number);
    return new Date(year, month - 1, day);
}

const formatarPeriodo = (periodoInicio: string, periodoFim: string) => {
    return [
        format(stringToDate(periodoInicio), 'dd/MM/yyyy'),
        format(stringToDate(periodoFim), 'dd/MM/yyyy'),
    ];
};

watchEffect(() => {
    eventosComUUID.value = processaEventos(props.eventos);
    periodoEspelhoFormatado.value = formatarPeriodo(props.espelho.periodo_inicio, props.espelho.periodo_fim);
    props.promotorias.forEach(separaPromotoriasPorMunicipio);
    processarPromotorias(promotoriasMacapa.value);
    processarPromotorias(promotoriasSantana.value);
    processarPromotorias(promotoriasInterior.value);
    atualizaAsAtribuicoes(eventosComUUID.value);
    processaAtendimentosUrgenciaDados(props.urgenciaAtendimentos);
});
</script>

<template>
    <Head title="Espelho" />
    <AuthenticatedLayout>
      <Preview
          :periodoEspelho="periodoEspelhoFormatado"
          :grupoPromotoriaDeTodasAsPromotorias="grupoDeTodasAsPromotoriasDados"
          :listaAtribuicoes="listaAtribuicoes"
          :atendimentosUrgenciaDados="atendimentosUrgenciaDados"
      />
    </AuthenticatedLayout>
</template>
