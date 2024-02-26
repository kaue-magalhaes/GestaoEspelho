<script setup lang="ts">
import { Promotoria } from '@/types';
import { onMounted } from 'vue';

import TabelaPromotoriaPreview from '@/Components/EspelhoComponents/PreviewComponents/TabelaPromotoriaPreview.vue';

type DadosType = { promotoria: Promotoria; evento: string }[];

const props = defineProps({
  promotoriasInteriorAgenda: {
    type: Array as () => { promotoria: Promotoria; evento: string }[],
    required: true,
  },
});

const dadosDeTeste: DadosType = [
  {
    promotoria: {
      id: 1,
      nome: '1ª Promotoria',
      municipio: 'Laranjal do Jari',
      promotor_id: 1,
      promotor: {
        id: 1,
        nome: 'Promotor de Justiça de Santana',
        is_substituto: false,
        created_at: '2021-08-10T00:00:00',
        updated_at: '2021-08-10T00:00:00',
      },
      created_at: '2021-08-10T00:00:00',
      updated_at: '2021-08-10T00:00:00',
    },
    evento: 'Férias',
  },
  {
    promotoria: {
      id: 2,
      nome: '2ª Promotoria',
      municipio: 'Laranjal do Jari',
      promotor_id: 2,
      promotor: {
        id: 2,
        nome: 'Promotor de Justiça de Santana',
        is_substituto: false,
        created_at: '2021-08-10T00:00:00',
        updated_at: '2021-08-10T00:00:00',
      },
      created_at: '2021-08-10T00:00:00',
      updated_at: '2021-08-10T00:00:00',
    },
    evento: 'Férias',
  },
  {
    promotoria: {
      id: 3,
      nome: '3ª Promotoria',
      municipio: 'Laranjal do Jari',
      promotor_id: 3,
      promotor: {
        id: 3,
        nome: 'Promotor de Justiça de Santana',
        is_substituto: false,
        created_at: '2021-08-10T00:00:00',
        updated_at: '2021-08-10T00:00:00',
      },
      created_at: '2021-08-10T00:00:00',
      updated_at: '2021-08-10T00:00:00',
    },
    evento: 'Férias',
  },
  {
    promotoria: {
      id: 4,
      nome: '4ª Promotoria',
      municipio: 'Laranjal do Jari',
      promotor_id: 4,
      promotor: {
        id: 4,
        nome: 'Promotor de Justiça de Santana',
        is_substituto: false,
        created_at: '2021-08-10T00:00:00',
        updated_at: '2021-08-10T00:00:00',
      },
      created_at: '2021-08-10T00:00:00',
      updated_at: '2021-08-10T00:00:00',
    },
    evento: 'Férias',
  },
  {
    promotoria: {
      id: 5,
      nome: '1ª Promotoria',
      municipio: 'Santana',
      promotor_id: 4,
      promotor: {
        id: 4,
        nome: 'Promotor de Justiça de Santana',
        is_substituto: false,
        created_at: '2021-08-10T00:00:00',
        updated_at: '2021-08-10T00:00:00',
      },
      created_at: '2021-08-10T00:00:00',
      updated_at: '2021-08-10T00:00:00',
    },
    evento: 'Férias',
  },
]

const agruparPorMunicipio = (dados: DadosType) => {
  return dados.reduce((grupos: { [key: string]: DadosType }, item) => {
    const chave = item.promotoria.municipio;
    if (!grupos[chave]) {
      grupos[chave] = [];
    }
    grupos[chave].push(item);
    return grupos;
  }, {});
};

const dadosAgrupados = agruparPorMunicipio(dadosDeTeste);

onMounted(() => {

});
</script>

<template>
  <div class="max-w-5xl w-full mx-auto flex flex-col items-center space-y-4">
    <h1 class="text-2xl font-bold text-gray-700 dark:text-gray-200">
      Entrância Inicial
    </h1>
    <TabelaPromotoriaPreview
     :dados="dadosAgrupados"
    />
  </div>
</template>