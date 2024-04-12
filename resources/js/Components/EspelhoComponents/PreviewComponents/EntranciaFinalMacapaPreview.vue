<script setup lang="ts">
import {GrupoPromotoria} from "@/Interfaces/GrupoPromotoria";
import {UrgenciaAtendimentoClientSide} from "@/Interfaces/UrgenciaAtendimentoClientSide";

import {onMounted, ref, watchEffect} from 'vue';

const props = defineProps({
    grupoPromotorias: {
        type: Array as () => GrupoPromotoria[],
        required: true,
    },
    urgenciaAtendimentos: {
        type: Array as () => UrgenciaAtendimentoClientSide[],
        required: true,
    },
});

const grupoPromotoriasNaoEspecializadas = ref<GrupoPromotoria[]>([]);
const grupoPromotoriasEspecializadas = ref<GrupoPromotoria[]>([]);

watchEffect(() => {
    props.grupoPromotorias.forEach((grupoPromotoria) => {
        if (grupoPromotoria.promotorias){
            let grupoPromotoriaCopyEspecializada = {...grupoPromotoria};
            let grupoPromotoriaCopyNaoEspecializada = {...grupoPromotoria};
            grupoPromotoriaCopyEspecializada.promotorias = [];
            grupoPromotoriaCopyNaoEspecializada.promotorias = [];
            grupoPromotoria.promotorias.forEach((promotoria) => {
                if (promotoria.is_especializada) {
                    grupoPromotoriaCopyEspecializada.promotorias?.push(promotoria);
                } else {
                    grupoPromotoriaCopyNaoEspecializada.promotorias?.push(promotoria);
                }
            });
            grupoPromotoriasEspecializadas.value.push(grupoPromotoriaCopyEspecializada);
            grupoPromotoriasNaoEspecializadas.value.push(grupoPromotoriaCopyNaoEspecializada);
        }
    });
});
</script>

<template>
    <div class="max-w-5xl w-full mx-auto flex flex-col items-center space-y-4"
         v-if="props.grupoPromotorias.length > 0 || props.urgenciaAtendimentos.length > 0">
        <div class="w-full mx-auto flex flex-col items-center space-y-4"
             v-if="grupoPromotoriasNaoEspecializadas.length > 0 || props.urgenciaAtendimentos.length > 0">
            <h1 class="text-2xl font-bold text-gray-700 dark:text-gray-200 mt-4">
                Entrância Final – Macapá
            </h1>
            <PlantaoCaraterUrgenciaPreview
                v-if="props.urgenciaAtendimentos.length > 0"
                :plantaoDeAtendimentos="props.urgenciaAtendimentos"
            />
            <TabelaPromotoriaPreview
                v-if="grupoPromotoriasNaoEspecializadas.length > 0"
                :grupoPromotorias="grupoPromotoriasNaoEspecializadas"
            />
        </div>
        <div class="w-full mx-auto flex flex-col items-center space-y-4" v-if="grupoPromotoriasEspecializadas.length > 0">
            <h1 class="text-2xl font-bold text-gray-700 dark:text-gray-200 mt-4">
                Entrância Final – Macapá (Especializadas)
            </h1>
            <TabelaPromotoriaPreview
                v-if="grupoPromotoriasEspecializadas.length > 0"
                :grupoPromotorias="grupoPromotoriasEspecializadas"
            />
        </div>
    </div>
</template>
