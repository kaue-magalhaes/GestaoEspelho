<script setup lang="ts">
import { Promotoria } from '@/types';
import { onMounted, ref } from 'vue';
import { format } from 'date-fns';


import TabelaPromotoriaEditor from '@/Components/EspelhoComponents/EditorComponents/TabelaPromotoriaEditor.vue';

type Evento = {
  id: number;
  tipo: string;
  periodo:{
    start: Date | null;
    end: Date | null;
  };
  titulo: string;
  promotorDesignado: string;
};

type Municipios = {
  nome: string;
  promotorias: {
    nome: string;
    nomePromotor: string;
    eventos: {
      id: number;
      tipo: string;
      periodo: string[];
      titulo: string;
      promotorDesignado: string;
    }[];
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

const adicionaEvento = (promotoriaId: number, municipio: Municipios, evento: Evento) => {
  //console.log(municipiosDados.value);
  municipiosDados.value.nome = municipio.nome;
  if (evento.periodo.start && evento.periodo.end) {
    municipiosDados.value.promotorias.push({
      nome: municipio.promotorias[promotoriaId].nome,
      nomePromotor: municipio.promotorias[promotoriaId].nomePromotor,
      eventos: [
        {
          id: evento.id,
          tipo: evento.tipo,
          periodo: [format(evento.periodo.start, 'dd/MM/yyyy'), format(evento.periodo.end, 'dd/MM/yyyy')],
          titulo: evento.titulo,
          promotorDesignado: evento.promotorDesignado,
        },
      ],
    });
  }
  //console.log(municipiosDados.value);  
  
  emit('update:adicionaMunicipiosDados', municipiosDados.value);

  resetMunicipiosDados();
};

const deleteEventoInterior = (eventoId: number, nomePromotoria: string) => {
  emit('delete:deleteEventoInterior', eventoId, nomePromotoria);
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