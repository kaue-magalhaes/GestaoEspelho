<script setup lang="ts">
import { Promotoria } from '@/types';
import { onMounted, watch } from 'vue';

import TabelaPromotoriaPreview from '@/Components/EspelhoComponents/PreviewComponents/TabelaPromotoriaPreview.vue';

const props = defineProps({
  promotoriasInteriorAgenda: {
    type: Array as () => { promotoria: Promotoria; eventoFormatado: { tipo: string; periodo: string[]; titulo: string; promotorDesignado: string } }[],
    required: true,
  },
});

const agruparPorMunicipio = (dados: typeof props.promotoriasInteriorAgenda) => {
  return dados.reduce((grupos: { [key: string]: typeof props.promotoriasInteriorAgenda }, item) => {
    const chave = item.promotoria.municipio;
    if (!grupos[chave]) {
      grupos[chave] = [];
    }
    grupos[chave].push(item);
    return grupos;
  }, {});
};

var dadosAgrupados = agruparPorMunicipio(props.promotoriasInteriorAgenda);

onMounted(() => {

});

watch(props.promotoriasInteriorAgenda, (newValue) => {
  dadosAgrupados = agruparPorMunicipio(newValue);
});
</script>

<template>
  <div class="max-w-5xl w-full mx-auto flex flex-col items-center space-y-4" v-if="promotoriasInteriorAgenda.length > 0">
    <h1 class="text-2xl font-bold text-gray-700 dark:text-gray-200">
      Entrância Inicial
    </h1>
    <TabelaPromotoriaPreview
     :dados="dadosAgrupados"
    />
  </div>
</template>