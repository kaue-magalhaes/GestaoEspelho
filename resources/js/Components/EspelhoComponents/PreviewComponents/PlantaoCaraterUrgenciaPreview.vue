<script setup lang="ts">
import { Promotor, UrgenciaAtendimento } from "@/types";
import { ref } from "vue";
import { usePage } from "@inertiajs/vue3";

const page = usePage();
defineProps({
    plantaoDeAtendimentos: {
    type: Array as () => UrgenciaAtendimento[],
    required: true,
  },
});

const promotoresQuePodemAtender = ref<Promotor[]>(page.props.promotores || []);

</script>
<template>
    <div v-if="plantaoDeAtendimentos.length > 0" class="w-full border-2 border-black p-4 rounded-md">
        <div class="w-full flex flex-col items-center">
            <h2 class="text-xl font-bold mb-4">PLANTÃO DE ATENDIMENTOS EM CARÁTER DE URGÊNCIA - MACAPÁ/SANTANA</h2>
            <ul class="grid grid-cols-2 gap-4">
                <li class="mb-2 text-left" v-for="atendimento in plantaoDeAtendimentos" :key="atendimento.id">
                    <span class="font-semibold">
                          - {{ promotoresQuePodemAtender.find((promotor) => promotor.id === atendimento.promotor_designado_id)?.nome }}:
                    </span>
                    <span v-if="atendimento.periodo_inicio === atendimento.periodo_fim">
                        ({{ atendimento.periodo_inicio }})
                    </span>
                    <span v-else>
                        ({{ atendimento.periodo_inicio }} - {{ atendimento.periodo_fim }})
                    </span>
                </li>
            </ul>
        </div>
    </div>
</template>
