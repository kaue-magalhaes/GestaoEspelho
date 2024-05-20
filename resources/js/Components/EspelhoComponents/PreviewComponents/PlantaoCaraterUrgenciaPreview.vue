<script setup lang="ts">
import {UrgenciaAtendimento} from "@/Interfaces/UrgenciaAtendimento/UrgenciaAtendimento";
import {Promotor} from "@/Interfaces/Promotor/Promotor";

import { usePage } from "@inertiajs/vue3";
import { format } from 'date-fns';
import {onMounted} from "vue";

const page = usePage();
const props = defineProps({
    promotores: {
        type: Array as () => Promotor[],
        required: true,
    },
    plantaoDeAtendimentos: {
    type: Array as () => UrgenciaAtendimento[],
    required: true,
  },
});

const historicoPromotores = page.props.historicoPromotores as Promotor[];

function stringToDate(dateString: string) {
  const [year, month, day] = dateString.split('-').map(Number);
  return new Date(year, month - 1, day);
}

onMounted(() => {

});
</script>
<template>
    <div v-if="plantaoDeAtendimentos.length > 0" class="w-full border-2 border-black p-4 rounded-md">
        <div class="w-full flex flex-col items-center">
            <h2 class="text-xl font-bold mb-4">PLANTÃO DE ATENDIMENTOS EM CARÁTER DE URGÊNCIA - MACAPÁ/SANTANA</h2>
            <ul class="grid grid-cols-2 gap-4">
                <li class="mb-2 text-left" v-for="atendimento in plantaoDeAtendimentos" :key="atendimento.uuid">
                    <span v-if="atendimento.periodo_inicio !== ''">
                        <span class="font-semibold">
                            - {{
                                promotores.find(promotor => promotor.id === atendimento.promotor_designado_id)?.nome ||
                                historicoPromotores.find(promotor => promotor.id === atendimento.promotor_designado_id)?.nome
                            }}
                        </span>
                        <span v-if="atendimento.periodo_inicio === atendimento.periodo_fim">
                            ({{ format(stringToDate(atendimento.periodo_inicio), 'dd/MM/yyyy') }})
                        </span>
                        <span v-else>
                            ({{ format(stringToDate(atendimento.periodo_inicio), 'dd/MM/yyyy') }} - {{ format(stringToDate(atendimento.periodo_fim), 'dd/MM/yyyy') }})
                        </span>
                    </span>
                </li>
            </ul>
        </div>
    </div>
</template>
