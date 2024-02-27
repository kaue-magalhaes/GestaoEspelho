<script setup lang="ts">
import { Promotoria } from '@/types';
import { onMounted } from 'vue';

import TabelaPromotoriaEditor from '@/Components/EspelhoComponents/EditorComponents/TabelaPromotoriaEditor.vue';

const emit = defineEmits([
  'update:adicionaEvento',
  'delete:deleteEventoInterior',
]);

const props = defineProps({
  promotoriasInterior: {
    type: Array as () =>  Promotoria[],
    required: true,
  },
});

const agruparPorMunicipio = (dados: typeof props.promotoriasInterior) => {
  return dados.reduce((grupos: { [key: string]: typeof props.promotoriasInterior }, item) => {
    const chave = item.municipio;
    if (!grupos[chave]) {
      grupos[chave] = [];
    }
    grupos[chave].push(item);
    return grupos;
  }, {});
};

const dadosAgrupados = agruparPorMunicipio(props.promotoriasInterior);

const adicionaEvento = (unidade: Promotoria, evento: { tipo: string; periodo: { start: Date; end: Date }; titulo: string; promotorDesignado: string }) => {
  //console.log(unidade);
  
  emit('update:adicionaEvento', unidade, evento);
};

const deleteEventoInterior = (promotoria_id: number) => {
  emit('delete:deleteEventoInterior', promotoria_id);
};

onMounted(() => {

});
</script>

<template>
  <div class="max-w-5xl w-full mx-auto flex flex-col items-center space-y-4">
    <h1 class="text-2xl font-bold text-gray-700 dark:text-gray-200">
      Entrância Inicial
    </h1>
    <TabelaPromotoriaEditor
     :dados="dadosAgrupados"
     @update:adicionaEvento="adicionaEvento"
     @delete:deleteEvento="deleteEventoInterior"
    />
  </div>
</template>