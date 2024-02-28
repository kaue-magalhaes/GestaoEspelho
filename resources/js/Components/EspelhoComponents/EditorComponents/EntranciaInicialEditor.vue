<script setup lang="ts">
import { Promotoria } from '@/types';
import { onMounted, ref } from 'vue';
import { format } from 'date-fns';


import TabelaPromotoriaEditor from '@/Components/EspelhoComponents/EditorComponents/TabelaPromotoriaEditor.vue';

type Evento = {
  tipo: string;
  periodo: string[];
  titulo: string;
  promotorDesignado: string;
};


type Municipios = {
  nome: string;
  promotorias: {
    nome: string;
    nomePromotor: string;
    eventos: Evento[];
  }[];
};

const emit = defineEmits([
  'update:adicionaMunicipiosDados',
  'delete:deleteEventoInterior',
]);

const props = defineProps({
  municipiosInterior: {
    type: Array as () => Municipios[],
    required: true,
  },
});

const municipiosDados = ref<Municipios>({
  nome: '',
  promotorias: [],
});

const resetMunicipiosDados = () => {
  municipiosDados.value = {
    nome: '',
    promotorias: [],
  };
};

const adicionaEvento = (promotoriaId: number, municipio: Municipios, evento: { tipo: string; periodo: { start: Date; end: Date }; titulo: string; promotorDesignado: string }) => {
  //console.log(municipiosDados.value);
  municipiosDados.value.nome = municipio.nome;
  municipiosDados.value.promotorias.push({
    nome: municipio.promotorias[promotoriaId].nome,
    nomePromotor: municipio.promotorias[promotoriaId].nomePromotor,
    eventos: [
      {
        tipo: evento.tipo,
        periodo: [format(evento.periodo.start, 'dd/MM/yyyy'), format(evento.periodo.end, 'dd/MM/yyyy')],
        titulo: evento.titulo,
        promotorDesignado: evento.promotorDesignado,
      },
    ],
  });
  //console.log(municipiosDados.value);

  //console.log(municipiosDados.value);
  
  
  emit('update:adicionaMunicipiosDados', municipiosDados.value);

  resetMunicipiosDados();
};

const deleteEventoInterior = (promotoria_id: number) => {
  emit('delete:deleteEventoInterior', promotoria_id);
};

onMounted(() => {

});
</script>

<template>
  <div class="max-w-5xl w-full mx-auto flex flex-col items-center space-y-4">
    <h1 class="text-2xl font-bold text-gray-700 dark:text-gray-200">
      Entrância Inicial
    </h1>
    <TabelaPromotoriaEditor
     :municipios="municipiosInterior"
     @update:adicionaEvento="adicionaEvento"
     @delete:deleteEvento="deleteEventoInterior"
    />
  </div>
</template>