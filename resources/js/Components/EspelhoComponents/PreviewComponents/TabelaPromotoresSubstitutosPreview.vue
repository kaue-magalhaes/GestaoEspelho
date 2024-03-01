<script setup lang="ts">
import { Atribuicoes } from '@/types';
import { onMounted } from 'vue';

const props = defineProps({
  listaAtribuicoes: {
    type: Array as () => Atribuicoes[],
    required: true,
  },
});

onMounted(() => {
  //console.log(props.listaAtribuicoes);
});
</script>

<template>
  <div class="max-w-5xl w-full mx-auto flex flex-col items-center space-y-4" v-if="props.listaAtribuicoes.length > 0">
    <h1 class="text-2xl font-bold text-gray-700 dark:text-gray-200">
      Promotores de Justiça Substitutos
    </h1>
    <table class="w-full text-black">
      <thead class="text-xs text-black uppercase bg-gray-300 border border-gray-400 text-center">
        <tr class="text-center text-base">
          <th class="w-1/2 px-6 py-4 border border-gray-400">
            PROMOTOR (A)
          </th>
          <th class="w-1/2 px-6 py-4 border border-gray-400">
            ATRIBUIÇÕES
          </th>
        </tr>
      </thead>
      <tbody class="text-center">
        <tr class="bg-white hover:bg-gray-50 border" v-for="atribuicoes in props.listaAtribuicoes" :key="atribuicoes.id">
          <td class="border px-6 py-4 font-medium">
            {{ atribuicoes.nome_promotor }}
          </td>
          <td class="border px-6 py-4 font-medium">
            <span class="flex items-center justify-center space-x-2" v-for="atribuicao in atribuicoes.atribuicoes" :key="atribuicao.id">
              <span>
                <span v-if="atribuicao.titulo !== ''">
                {{ atribuicao.tipo }} - {{ atribuicao.titulo }}
                </span>
                <span v-else>
                  {{ atribuicao.tipo }}
                </span>
              </span>
              <p class="text-xs">
                ({{ atribuicao.periodo[0] }} - {{ atribuicao.periodo[1] }})
              </p>
            </span>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>