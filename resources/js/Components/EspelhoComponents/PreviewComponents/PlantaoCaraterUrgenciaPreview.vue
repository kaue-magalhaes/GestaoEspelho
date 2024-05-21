<script setup lang="ts">
import {Promotor} from "@/Interfaces/Promotor/Promotor";

import {usePage} from "@inertiajs/vue3";
import {format} from 'date-fns';
import {useUrgenciaAtendimentosStore} from "@/stores/urgenciaAtendimentoStore";
import {storeToRefs} from "pinia";

const page = usePage();

const store = useUrgenciaAtendimentosStore();
const { urgenciaAtendimentos, loading } = storeToRefs(store);

const props = defineProps({
    promotores: {
        type: Array as () => Promotor[],
        required: true,
    },
});

const historicoPromotores = page.props.historicoPromotores as Promotor[];

</script>
<template>
    <div v-if="loading" class="w-full border-2 border-black p-4 rounded-md">
        Carregando...
    </div>
    <div v-else class="w-full border-2 border-black p-4 rounded-md">
        <div class="w-full flex flex-col items-center">
            <h2 class="text-xl font-bold mb-4">PLANTÃO DE ATENDIMENTOS EM CARÁTER DE URGÊNCIA - MACAPÁ/SANTANA</h2>
            <ul class="grid grid-cols-2 gap-4">
                <li class="mb-2 text-left" v-for="atendimento in urgenciaAtendimentos.data" :key="atendimento.uuid">
                    <span v-if="atendimento.periodo_inicio && atendimento.promotor_designado_id !== ''">
                        <span class="font-semibold">
                            - {{
                                promotores.find(promotor => promotor.id === atendimento.promotor_designado_id)?.nome ||
                                historicoPromotores.find(promotor => promotor.id === atendimento.promotor_designado_id)?.nome
                            }}
                        </span>
                        <span v-if="format(atendimento.periodo_inicio, 'dd/MM/yyyy') === format(atendimento.periodo_fim, 'dd/MM/yyyy')">
                            ({{ format(atendimento.periodo_inicio, 'dd/MM/yyyy') }})
                        </span>
                        <span v-else>
                            ({{
                                format(atendimento.periodo_inicio, 'dd/MM/yyyy')
                            }} - {{ format(atendimento.periodo_fim, 'dd/MM/yyyy') }})
                        </span>
                    </span>
                </li>
            </ul>
        </div>
    </div>
</template>
