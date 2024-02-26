<script setup lang="ts">
import { Promotor, Promotoria } from '@/types';
import { ref, onMounted } from 'vue';

import { Button } from '@/Components/ui/button';
import { Label } from '@/Components/ui/label';
import { Input } from '@/Components/ui/input';
import { Card } from '@/Components/ui/card';

import PlantaoCaraterUrgenciaMacapa from '@/Components/EspelhoComponents/PlantaoCaraterUrgenciaMacapa.vue';
import EntranciaFinalMacapaTabela from '@/Components/EspelhoComponents/EntranciaFinalMacapaTabela.vue';

const emit = defineEmits([
  'update:promotorUrgencia',
  'update:periodoUrgencia',
  'remove:promotorUrgenciaItem',
  'update:promotorias',
]);

/* const props = defineProps({
  promotores: {
    type: Object as () => { all: Promotor[]; },
    required: true,
  },
  promotorias: {
    type: Object as () => { all: Promotoria[]; },
    required: true,
  },
}); */

const updatePromotorUrgencia = (index: number, value: string) => {
  emit('update:promotorUrgencia', index, value);
};

const updatePeriodoUrgencia = (index: number, value: Date) => {
  emit('update:periodoUrgencia', index, value);
};

const removePromotorUrgenciaItem = (index: number) => {
  emit('remove:promotorUrgenciaItem', index);
};

const updatePromotorias = (value: { all: Promotoria[] }) => {
  emit('update:promotorias', value);
};
</script>

<template>
  <div class="grid grid-cols-2 gap-4">
    <!-- <PlantaoCaraterUrgenciaMacapa 
      :promotores="promotores"
      @update:promotor-urgencia="updatePromotorUrgencia"
      @update:periodo-urgencia="updatePeriodoUrgencia"
      @remove:promotor-urgencia-item="removePromotorUrgenciaItem"
    />
    <div class="col-span-2 max-w-5xl w-full flex flex-col items-center space-y-4">
      <EntranciaFinalMacapaTabela 
        :promotorias="promotorias"
        :promotores="promotores"
        @update:promotorias="updatePromotorias"
      />
    </div> -->
    <!-- titulo PROMOTORIAS DE JUSTIÇA DE ENTRÂNCIA FINAL – MACAPÁ -->
    <PlantaoCaraterUrgenciaEditor />
    <TabelaPromotoriasEditor />
    <!-- titulo PROMOTORIAS DE JUSTIÇA DE ENTRÂNCIA FINAL – MACAPÁ – PROMOTORIAS ESPECIALIZADAS -->
    <TabelaPromotoriasEspecializadas />
  </div>
</template>