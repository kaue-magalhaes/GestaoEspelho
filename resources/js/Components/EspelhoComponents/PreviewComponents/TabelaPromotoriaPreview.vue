<script setup lang="ts">
import { Promotoria } from '@/types';

const props = defineProps({
  dados: {
    type: Array as () => { promotoria: Promotoria; evento: string }[],
    required: true,
  },
});
</script>

<template>
  <table class="w-full text-black" v-if="props.dados.length > 1">
    <tbody class="text-center">
      <tr class="text-black uppercase bg-gray-300 border border-gray-400 text-center text-base">
        <th class="px-6 py-4 border border-gray-400">
          {{ dados[0].promotoria.municipio }}
        </th>
        <th class="px-6 py-4 border border-gray-400">
          Promotor
        </th>
        <th class="px-6 py-4 border border-gray-400">
          Periodo
        </th>
      </tr>
      <tr class="bg-white hover:bg-gray-50" v-for="dado in props.dados" :key="dado.promotoria.id">
        <td class="border px-6 py-4 font-medium whitespace-nowrap">
          {{ dado.promotoria.nome }}
        </td>
        <td class="border px-6 py-4">
          <div class="flex flex-col items-center">
            <h1 class="font-bold text-gray-900 dark:text-gray-200">
              {{ dado.promotoria.promotor.nome }}
            </h1>
          </div>
        </td>
        <td class="border px-6 py-4">
          <!-- evento que o promotor titular vai ficar ocupado e quem vai substituir -->
          {{ dado.evento }}
        </td>
      </tr>
    </tbody>
  </table>

  <table class="w-full text-black" v-else-if="props.dados.length === 1">
    <tbody class="text-center">
      <tr class="text-black uppercase bg-gray-300 border-gray-400 border text-center text-base">
        <th class="px-6 py-4 border border-gray-400" rowspan="2">
          {{ dados[0].promotoria.nome }}
        </th>
        <th class="px-6 py-4 border border-gray-400">
          Promotor
        </th>
        <th class="px-6 py-4 border border-gray-400">
          Periodo
        </th>
      </tr>
      <tr class="bg-white hover:bg-gray-50" v-for="dado in props.dados" :key="dado.promotoria.id">
        <td class="border px-6 py-4">
          <!-- promotor titular -->
          <div class="flex flex-col items-center">
            <h1 class="font-bold text-gray-900 dark:text-gray-200">
              {{ dado.promotoria.promotor.nome }}
            </h1>
          </div>
        </td>
        <td class="border px-6 py-4">
          <!-- evento que o promotor titular vai ficar ocupado e quem vai substituir -->
          {{ dado.evento }}
        </td>
      </tr>
    </tbody>
  </table>
</template>