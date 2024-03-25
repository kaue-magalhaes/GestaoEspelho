<script setup lang="ts">
import { Promotor, UrgenciaAtendimentoServeSide } from "@/types";
import { usePage } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";
import { format } from 'date-fns';

const page = usePage();
const props = defineProps({
    plantaoDeAtendimentos: {
    type: Array as () => UrgenciaAtendimentoServeSide[],
    required: true,
  },
});

const promotoresQuePodemAtender = ref<Promotor[]>(page.props.promotores || []);

function stringToDate(dateString: string) {
  const [year, month, day] = dateString.split('-').map(Number);
  return new Date(year, month - 1, day);
}

onMounted(() => {
  console.log('plantaoDeAtendimentos', props.plantaoDeAtendimentos);
  console.log('promotoresQuePodemAtender', promotoresQuePodemAtender.value);
});

</script>
<template>
    <div v-if="plantaoDeAtendimentos.length > 0" class="w-full border-2 border-black p-4 rounded-md">
        <div class="w-full flex flex-col items-center">
            <h2 class="text-xl font-bold mb-4">PLANTÃO DE ATENDIMENTOS EM CARÁTER DE URGÊNCIA - MACAPÁ/SANTANA</h2>
            <ul class="grid grid-cols-2 gap-4">
                <li class="mb-2 text-left" v-for="atendimento in plantaoDeAtendimentos" :key="atendimento.id">
                    <span v-if="atendimento.periodo_inicio !== ''">
                        <span class="font-semibold">
                            - {{ promotoresQuePodemAtender.find((promotor) => promotor.id === atendimento.promotor_designado_id)?.nome }}:
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
