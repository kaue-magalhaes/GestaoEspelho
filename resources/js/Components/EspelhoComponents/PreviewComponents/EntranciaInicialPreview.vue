<script setup lang="ts">
import { Promotoria } from '@/types';
import { onMounted } from 'vue';

import TabelaPromotoriaPreview from '@/Components/EspelhoComponents/PreviewComponents/TabelaPromotoriaPreview.vue';

const props = defineProps({
  promotoriasInteriorAgenda: {
    type: Array as () => { promotoria: Promotoria; evento: string }[],
    required: true,
  },
});

const dadosDeTeste = [
  {
    promotoria: {
      id: 1,
      nome: '1ª Promotoria',
      municipio: 'Laranjal do Jari',
      promotor: {
        id: 1,
        nome: 'Promotor de Justiça de Santana',
      },
    },
    evento: 'Férias',
  },
  {
    promotoria: {
      id: 2,
      nome: '2ª Promotoria',
      municipio: 'Laranjal do Jari',
      promotor: {
        id: 2,
        nome: 'Promotor de Justiça de Macapá',
      },
    },
    evento: 'Licença',
  },
  {
    promotoria: {
      id: 3,
      nome: '3ª Promotoria',
      municipio: 'Laranjal do Jari',
      promotor: {
        id: 3,
        nome: 'Promotor de Justiça de Macapá',
      },
    },
    evento: 'Licença',
  },
  {
    promotoria: {
      id: 4,
      nome: '4ª Promotoria',
      municipio: 'Laranjal do Jari',
      promotor: {
        id: 4,
        nome: 'Promotor de Justiça de Macapá',
      },
    },
    evento: 'Licença',
  },
  {
    promotoria: {
      id: 5,
      nome: '5ª Promotoria',
      municipio: 'Laranjal do Jari',
      promotor: {
        id: 5,
        nome: 'Promotor de Justiça de Macapá',
      },
    },
    evento: 'Licença',
  },
  {
    promotoria: {
      id: 6,
      nome: '6ª Promotoria',
      municipio: 'Laranjal do Jari',
      promotor: {
        id: 6,
        nome: 'Promotor de Justiça de Macapá',
      },
    },
    evento: 'Licença',
  },
  {
    promotoria: {
      id: 7,
      nome: '7ª Promotoria',
      municipio: 'Laranjal do Jari',
      promotor: {
        id: 7,
        nome: 'Promotor de Justiça de Macapá',
      },
    },
    evento: 'Licença',
  },
  {
    promotoria: {
      id: 8,
      nome: '8ª Promotoria',
      municipio: 'Laranjal do Jari',
      promotor: {
        id: 8,
        nome: 'Promotor de Justiça de Macapá',
      },
    },
    evento: 'Licença',
  },
]

</script>

<template>
  <div class="max-w-5xl w-full mx-auto flex flex-col items-center space-y-4">
    <h1 class="text-2xl font-bold text-gray-700 dark:text-gray-200">
      Entrância Inicial
    </h1>
    <TabelaPromotoriaPreview
     :dados="dadosDeTeste"
    />
  </div>
</template>