<script setup lang="ts">
import {AtendimentoUrgencia} from "@/types";

const props = defineProps({
  atendimentosUrgencia: {
    type: Array as () => AtendimentoUrgencia[],
    required: true,
  },
});
</script>
<template>
  <div v-if="atendimentosUrgencia.length > 0" class="w-full border-2 border-black p-4 rounded-md">
    <div class="w-full flex flex-col items-center">
      <h2 class="text-xl font-bold mb-4">PLANTÃO DE ATENDIMENTOS EM CARÁTER DE URGÊNCIA - MACAPÁ/SANTANA</h2>
      <ul class="grid grid-cols-2 gap-4">
        <li class="mb-2 text-left" v-for="atendimento in atendimentosUrgencia" :key="atendimento.id">
          <span class="font-semibold"> - {{ atendimento.nome_promotor }}</span> <span> ({{ atendimento.periodo.start }} - {{ atendimento.periodo.end }})</span>
        </li>
      </ul>
    </div>
  </div>
</template>
