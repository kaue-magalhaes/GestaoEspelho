<script setup lang="ts">
import { Promotoria } from '@/types';
import { onMounted } from 'vue';

type DadosType = { promotoria: Promotoria; eventoFormatado: { tipo: string; periodo: string[]; titulo: string; promotorDesignado: string } }[];

const props = defineProps({
  dados: {
    type: Object as () => { [key: string]: DadosType },
    required: true,
  },
});

onMounted(() => {
  //console.log(props.dados);
});
</script>

<template>
  <div class="w-full" v-for="municipioKey in Object.keys(props.dados)" :key="municipioKey">
    <table class="w-full text-black" v-if="props.dados[municipioKey].length > 1">
      <tbody class="text-center">
        <tr class="text-black uppercase bg-gray-300 border border-gray-400 text-center text-base">
          <th class="w-1/3 px-6 py-4 border border-gray-400">
            {{ props.dados[municipioKey][0].promotoria.municipio }}
          </th>
          <th class="w-1/3 px-6 py-4 border border-gray-400">
            Promotor
          </th>
          <th class="w-1/3 px-6 py-4 border border-gray-400">
            Periodo
          </th>
        </tr>
        <tr class="bg-white hover:bg-gray-50" v-for="dadoPromotoria in props.dados[municipioKey]" :key="dadoPromotoria.promotoria.id">
          <td class="border px-6 py-4 font-medium">
            {{ dadoPromotoria.promotoria.nome }}
          </td>
          <td class="border px-6 py-4">
            <div class="flex flex-col items-center">
              <h1 class="font-bold text-gray-900 dark:text-gray-200">
                {{ dadoPromotoria.promotoria.promotor.nome }}
              </h1>
            </div>
          </td>
          <td class="border px-6 py-4">
            <div>
              {{ dadoPromotoria.eventoFormatado.tipo }} - {{ dadoPromotoria.eventoFormatado.titulo }}
            </div>
            <div>
              {{ dadoPromotoria.eventoFormatado.periodo[0] }} a {{ dadoPromotoria.eventoFormatado.periodo[1] }}
            </div>
            <div>
              Promotor designado: {{ dadoPromotoria.eventoFormatado.promotorDesignado }}
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  
    <table class="w-full text-black" v-else-if="props.dados[municipioKey].length === 1">
      <tbody class="text-center">
        <tr class="text-black uppercase bg-gray-300 border-gray-400 border text-center text-base">
          <th class="w-1/3 px-6 py-4 border border-gray-400" rowspan="2">
            {{ props.dados[municipioKey][0].promotoria.municipio }}
          </th>
          <th class="w-1/3 px-6 py-4 border border-gray-400">
            Promotor
          </th>
          <th class="w-1/3 px-6 py-4 border border-gray-400">
            Periodo
          </th>
        </tr>
        <tr class="bg-white hover:bg-gray-50" v-for="dadoPromotoria in props.dados[municipioKey]" :key="dadoPromotoria.promotoria.id">
          <td class="border px-6 py-4">
            <div class="flex flex-col items-center">
              <h1 class="font-bold text-gray-900 dark:text-gray-200">
                {{ dadoPromotoria.promotoria.promotor.nome }}
              </h1>
            </div>
          </td>
          <td class="border px-6 py-4">
            <div>
              {{ dadoPromotoria.eventoFormatado.tipo }} - {{ dadoPromotoria.eventoFormatado.titulo }}
            </div>
            <div>
              {{ dadoPromotoria.eventoFormatado.periodo[0] }} a {{ dadoPromotoria.eventoFormatado.periodo[1] }}
            </div>
            <div>
              Promotor designado: {{ dadoPromotoria.eventoFormatado.promotorDesignado }}
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>