<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { format } from 'date-fns';
import { watchEffect, ref } from 'vue';
import {Espelho} from "@/Interfaces/Espelho";
import {HistoricoPromotoria} from "@/Interfaces/Historico/HistoricoPromotoria";
import {Promotor} from "@/Interfaces/Promotor";
import {HistoricoEvento} from "@/Interfaces/Historico/HistoricoEvento";
import {HistoricoUrgenciaAtendimento} from "@/Interfaces/Historico/HistoricoUrgenciaAtendimento";
import {GrupoPromotoria} from "@/Interfaces/GrupoPromotoria";
import {Atribuicoes} from "@/Interfaces/Atribuicoes";
import {Evento} from "@/Interfaces/Evento";

const props = defineProps({
    espelho: {
        type: Object as () => Espelho,
        required: true,
    },
    grupoPromotorias: {
        type: Array as () => GrupoPromotoria[],
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
        type: Array as () => HistoricoEvento[],
        required: true,
    },
    urgenciaAtendimentos: {
        type: Array as () => HistoricoUrgenciaAtendimento[],
        required: true,
    },
});

const grupoDeTodasAsPromotoriasDados = ref<GrupoPromotoria[]>(props.grupoPromotorias);
const grupoDePromotoriasDados = ref<GrupoPromotoria[]>([]);
const promotoriasMacapa = ref<HistoricoPromotoria[]>([]);
const promotoriasSantana = ref<HistoricoPromotoria[]>([]);
const promotoriasInterior = ref<HistoricoPromotoria[]>([]);
const periodoEspelho = ref<string[]>([
    format(stringToDate(props.espelho?.periodo_inicio), 'dd/MM/yyyy'),
    format(stringToDate(props.espelho?.periodo_fim), 'dd/MM/yyyy'),
]);
const listaAtribuicoes = ref<Atribuicoes[]>([]);
const atendimentosUrgenciaDados = ref<any>([]);
const eventosComUUID = ref<Evento[]>([]);

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

const processaAtendimentosUrgenciaDados = (urgenciaAtendimentos: HistoricoUrgenciaAtendimento[]) => {
    urgenciaAtendimentos?.forEach((atendimentoUrgencia) => {
        atendimentosUrgenciaDados.value.push({
        uuid: atendimentoUrgencia.id,
        periodo_inicio: atendimentoUrgencia.periodo_inicio,
        periodo_fim: atendimentoUrgencia.periodo_fim,
        promotor_designado_id: atendimentoUrgencia.historico_promotor_designado_id,
        });
    });
}

function stringToDate(dateString: string) {
    const [year, month, day] = dateString.split('-').map(Number);
    return new Date(year, month - 1, day);
}

watchEffect(() => {
    atualizaAsAtribuicoes(eventosComUUID.value);
    processaAtendimentosUrgenciaDados(props.urgenciaAtendimentos);
    console.log(props.grupoPromotorias);
});
</script>

<template>
    <Head title="Espelho" />
    <Preview
        :periodoEspelho="periodoEspelho"
        :grupoPromotoriaDeTodasAsPromotorias="grupoDeTodasAsPromotoriasDados"
        :listaAtribuicoes="listaAtribuicoes"
        :atendimentosUrgenciaDados="atendimentosUrgenciaDados"
    />
</template>
