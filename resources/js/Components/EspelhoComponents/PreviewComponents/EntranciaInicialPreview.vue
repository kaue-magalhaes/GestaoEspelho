<script setup lang="ts">

import {GrupoPromotoria} from "@/Interfaces/GrupoPromotoria/GrupoPromotoria";
import {Promotor} from "@/Interfaces/Promotor/Promotor";

defineProps({
    promotores: {
        type: Array as () => Promotor[],
        required: true,
    },
    promotoriasDados: {
        type: Array as () => GrupoPromotoria[],
        required: true,
    },
});
</script>

<template>
    <div class="max-w-5xl w-full mx-auto flex flex-col items-center space-y-4" v-if="promotoriasDados.length > 0">
        <h1 class="text-2xl font-bold text-gray-700 dark:text-gray-200">
            Entrância Inicial
        </h1>
        <TabelaPromotoriaPreview
            :promotores="promotores"
            :grupoPromotorias="promotoriasDados"
        />
    </div>
</template>
