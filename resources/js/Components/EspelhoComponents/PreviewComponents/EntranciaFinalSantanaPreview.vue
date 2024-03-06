<script setup lang="ts">
import { GrupoPromotoria } from '@/types';
import { ref, watchEffect } from 'vue';

import TabelaPromotoriaPreview from '@/Components/EspelhoComponents/PreviewComponents/TabelaPromotoriaPreview.vue';

const props = defineProps({
  promotorias: {
    type: Array as () => GrupoPromotoria[],
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
          const index = promotoriasEspecializadas.value.findIndex((promotoriaEspecializada) => promotoriaEspecializada.nome_grupo_promotorias === grupoPromotoria.nome_grupo_promotorias);
          if (index === -1) {
            promotoriasEspecializadas.value.push(grupoPromotoria);
          }
        }
      } else {
        if (promotoriasNaoEspecializadas.value.length === 0) {
          promotoriasNaoEspecializadas.value.push(grupoPromotoria);
        } else {
          const index = promotoriasNaoEspecializadas.value.findIndex((promotoriaNaoEspecializada) => promotoriaNaoEspecializada.nome_grupo_promotorias === grupoPromotoria.nome_grupo_promotorias);
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
  <div class="max-w-5xl w-full mx-auto flex flex-col items-center space-y-4" v-if="props.promotorias.length > 0">
    <div class="w-full mx-auto flex flex-col items-center space-y-4" v-if="promotoriasNaoEspecializadas.length > 0">
      <h1 class="text-2xl font-bold text-gray-700 dark:text-gray-200 mt-4">
        Entrância Final – Santana
      </h1>
      <TabelaPromotoriaPreview
      :grupoPromotorias="promotoriasNaoEspecializadas"
      />
    </div>
    <div class="w-full mx-auto flex flex-col items-center space-y-4" v-if="promotoriasEspecializadas.length > 0">
      <h1 class="text-2xl font-bold text-gray-700 dark:text-gray-200 mt-4">
        Entrância Final – Santana (Especializadas)
      </h1>
      <TabelaPromotoriaPreview
      :grupoPromotorias="promotoriasEspecializadas"
      />
    </div>
  </div>
</template>