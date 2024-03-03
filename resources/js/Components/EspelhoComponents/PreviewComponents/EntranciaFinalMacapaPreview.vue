<script setup lang="ts">
import {AtendimentoUrgencia, GrupoPromotoria, Promotor} from '@/types';
import { ref, watchEffect } from 'vue';

import TabelaPromotoriaPreview from '@/Components/EspelhoComponents/PreviewComponents/TabelaPromotoriaPreview.vue';
import PlantaoCaraterUrgenciaPreview
  from "@/Components/EspelhoComponents/PreviewComponents/PlantaoCaraterUrgenciaPreview.vue";

const props = defineProps({
  promotorias: {
    type: Array as () => GrupoPromotoria[],
    required: true,
  },
  atendimentoUrgencia: {
    type: Array as () => AtendimentoUrgencia[],
    required: true,
  },
});

const promotoriasNaoEspecializadas = ref<GrupoPromotoria[]>([]);
const promotoriasEspecializadas = ref<GrupoPromotoria[]>([]);

watchEffect(() => {
  //console.log(props.promotorias);
  props.promotorias.forEach((grupoPromotoria) => {
    grupoPromotoria.promotorias.forEach((promotoria) => {
      if (promotoria.is_especializada) {
        if (promotoriasEspecializadas.value.length === 0) {
          promotoriasEspecializadas.value.push(grupoPromotoria);
        } else {
          const index = promotoriasEspecializadas.value.findIndex((promotoriaEspecializada) => promotoriaEspecializada.nome === grupoPromotoria.nome);
          if (index === -1) {
            promotoriasEspecializadas.value.push(grupoPromotoria);
          }
        }
      } else {
        if (promotoriasNaoEspecializadas.value.length === 0) {
          promotoriasNaoEspecializadas.value.push(grupoPromotoria);
        } else {
          const index = promotoriasNaoEspecializadas.value.findIndex((promotoriaNaoEspecializada) => promotoriaNaoEspecializada.nome === grupoPromotoria.nome);
          if (index === -1) {
            promotoriasNaoEspecializadas.value.push(grupoPromotoria);
          }
        }
      }
    });
  });
});
</script>

<template>
  
  <div class="max-w-5xl w-full mx-auto flex flex-col items-center space-y-4" v-if="props.promotorias.length > 0 || props.atendimentoUrgencia.length > 0">
    <div class="w-full mx-auto flex flex-col items-center space-y-4" v-if="promotoriasNaoEspecializadas.length > 0 || props.atendimentoUrgencia.length > 0">
      <h1 class="text-2xl font-bold text-gray-700 dark:text-gray-200 mt-4">
        Entrância Final – Macapá
      </h1>
      <PlantaoCaraterUrgenciaPreview
          v-if="props.atendimentoUrgencia.length > 0"
          :atendimentosUrgencia="props.atendimentoUrgencia"
      />
      <TabelaPromotoriaPreview
          v-if="promotoriasNaoEspecializadas.length > 0"
          :municipios="promotoriasNaoEspecializadas"
      />
    </div>
    <div class="w-full mx-auto flex flex-col items-center space-y-4" v-if="promotoriasEspecializadas.length > 0">
      <h1 class="text-2xl font-bold text-gray-700 dark:text-gray-200 mt-4">
        Entrância Final – Macapá (Especializadas)
      </h1>
      <TabelaPromotoriaPreview
          v-if="promotoriasEspecializadas.length > 0"
          :municipios="promotoriasEspecializadas"
      />
    </div>
  </div>
</template>