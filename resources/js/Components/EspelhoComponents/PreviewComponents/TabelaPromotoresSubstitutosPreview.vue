<script setup lang="ts">
import { onMounted } from 'vue';

const props = defineProps({
  listaPromotoresSubstitutosAtribuicoes: {
    type: Array as () => { promotor: Promotor; atribuicao: Array<string> }[],
    required: true,
  },
});

onMounted(() => {
  //console.log(props.listaPromotoresSubstitutosAtribuicoes);
});
</script>

<template>
  <div class="max-w-5xl w-full mx-auto flex flex-col items-center space-y-4">
    <table class="w-full text-black" v-if="props.listaPromotoresSubstitutosAtribuicoes.length > 0">
      <thead class="text-xs text-black uppercase bg-gray-300 border-x border-t">
        <tr class="text-center text-base">
          <th class="px-6 py-4">
            PROMOTOR (A)
          </th>
          <th class="px-6 py-3">
            ATRIBUIÇÕES
          </th>
        </tr>
      </thead>
      <tbody class="text-center">
        <tr class="bg-white hover:bg-gray-50 border" v-for="promotor in props.listaPromotoresSubstitutosAtribuicoes" :key="promotor.promotor.id">
          <th class="px-6 py-4 font-medium whitespace-nowrap">
            <div class="flex flex-col items-center">
              <h1 class="font-bold text-gray-900 dark:text-gray-200">
                {{ promotor.promotor.nome }}
              </h1>
            </div>
          </th>
          <td class="px-6 py-4">
            <h1 class="font-bold text-gray-900 dark:text-gray-200">
              Reunião CNMP
            </h1>
            <p class="text-xs">
              04/02/2024 - 06/02/2024
            </p>
            <p class="text-xs text-red-500">
              Designada Dra. Marcela (resp.)
            </p>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>