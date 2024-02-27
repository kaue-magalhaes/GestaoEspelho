<script setup lang="ts">
import { Promotoria } from '@/types';
import { onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';

import AdicionarEventoBotao from '@/Components/EspelhoComponents/AdicionarEventoBotao.vue';

const promotores = usePage().props.promotores;

const emit = defineEmits([
  'update:adicionaEvento',
]);

const props = defineProps({
  dados: {
    type: Object as () => { [key: string]: Promotoria[] },
    required: true,
  },
});

const adicionaEvento = (promotoriaKey: string, promotoria_id: number, evento: { tipo: string; periodo: { start: Date; end: Date }; titulo: string; promotorDesignado: string }) => {
  const unidade = props.dados[promotoriaKey].find((promotoria) => promotoria.id === promotoria_id);

  emit('update:adicionaEvento', unidade, evento);
};

onMounted(() => {
  //console.log(promotores);
  //console.log(props.dados);
  
});
</script>

<template>
  <div class="w-full" v-for="municipioKey in Object.keys(props.dados)" :key="municipioKey">
    <table class="w-full text-black" v-if="props.dados[municipioKey].length > 1">
      <tbody class="text-center">
        <tr class="text-black uppercase bg-gray-300 border border-gray-400 text-center text-base">
          <th class="w-1/3 px-6 py-4 border border-gray-400">
            {{ props.dados[municipioKey][0].municipio }}
          </th>
          <th class="w-1/3 px-6 py-4 border border-gray-400">
            Promotor
          </th>
          <th class="w-1/3 px-6 py-4 border border-gray-400">
            Periodo
          </th>
        </tr>
        <tr class="bg-white hover:bg-gray-50" v-for="dadoPromotoria in props.dados[municipioKey]" :key="dadoPromotoria.id">
          <td class="border px-6 py-4 font-medium">
            {{ dadoPromotoria.nome }}
          </td>
          <td class="border px-6 py-4 font-medium">
            {{ dadoPromotoria.promotor.nome }}
          </td>
          <td class="border px-6 py-4">
            <AdicionarEventoBotao
              :promotoriaKey="municipioKey"
              :promotoria="dadoPromotoria"
              :promotores="promotores"
              @update:adicionaEvento="adicionaEvento"
            />
          </td>
        </tr>
      </tbody>
    </table>
  
    <table class="w-full text-black" v-else-if="props.dados[municipioKey].length === 1">
      <tbody class="text-center">
        <tr class="text-black uppercase bg-gray-300 border-gray-400 border text-center text-base">
          <th class="w-1/3 px-6 py-4 border border-gray-400" rowspan="2">
            {{ props.dados[municipioKey][0].municipio }}
          </th>
          <th class="w-1/3 px-6 py-4 border border-gray-400">
            Promotor
          </th>
          <th class="w-1/3 px-6 py-4 border border-gray-400">
            Periodo
          </th>
        </tr>
        <tr class="bg-white hover:bg-gray-50" v-for="dadoPromotoria in props.dados[municipioKey]" :key="dadoPromotoria.id">
          <td class="border px-6 py-4">
            <div class="flex flex-col items-center">
              <h1 class="font-bold text-gray-900 dark:text-gray-200">
                {{ dadoPromotoria.promotor.nome }}
              </h1>
            </div>
          </td>
          <td class="border px-6 py-4">
            <AdicionarEventoBotao
              :promotoriaKey="municipioKey"
              :promotoria="dadoPromotoria"
              :promotores="promotores"
              @update:adicionaEvento="adicionaEvento"
            />
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>