<script setup lang="ts">
import { onMounted } from 'vue';

import TabelaPromotoriaPreview from '@/Components/EspelhoComponents/PreviewComponents/TabelaPromotoriaPreview.vue';

type Municipios = {
  nome: string;
  promotorias: {
    nome: string;
    nomePromotor: string;
    eventos: {
      id: number;
      tipo: string;
      periodo: string[];
      titulo: string;
      promotorDesignadoEvento: string;
    }[];
  }[];
};

const props = defineProps({
  municipiosDados: {
    type: Array as () => Municipios[],
    required: true,
  },
});

onMounted(() => {

});

</script>

<template>
  <div class="max-w-5xl w-full mx-auto flex flex-col items-center space-y-4" v-if="municipiosDados.length > 0">
    <h1 class="text-2xl font-bold text-gray-700 dark:text-gray-200">
      Entrância Inicial
    </h1>
    <TabelaPromotoriaPreview
     :municipios="municipiosDados"
    />
  </div>
</template>