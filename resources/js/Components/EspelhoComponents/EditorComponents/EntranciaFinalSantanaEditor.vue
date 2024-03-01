<script setup lang="ts">
import { ref, computed } from 'vue';


import TabelaPromotoriaEditor from '@/Components/EspelhoComponents/EditorComponents/TabelaPromotoriaEditor.vue';

type Evento = {
  id: number;
  tipo: string;
  periodo:{
    start: Date | null;
    end: Date | null;
  };
  titulo: string;
  promotorDesignadoEvento: string;
};

type Municipios = {
  nome: string;
  promotorias: {
    nome: string;
    isEspecializada: boolean;
    nomePromotor: string;
    eventos: {
      id: number;
      tipo: string;
      periodo: Date[];
      titulo: string;
      promotorDesignadoEvento: string;
    }[];
  }[];
};

const emit = defineEmits([
  'update:adicionaDados',
  'delete:deleteEvento',
  'update:editaEvento',
]);

const props = defineProps({
  promotoriasSantana: {
    type: Array as () => Municipios[],
    required: true,
  },
});

const promotoriasNaoEspecializadas = computed(() => {
  return props.promotoriasSantana.filter((promotoria) => promotoria.promotorias[0].isEspecializada === false);
});
const promotoriasEspecializadas = computed(() => {
  return props.promotoriasSantana.filter((promotoria) => promotoria.promotorias[0].isEspecializada === true);
});

const dadosPromotoria = ref<Municipios>({
  nome: '',
  promotorias: [],
});

const resetDadosPromotoria = () => {
  dadosPromotoria.value = {
    nome: '',
    promotorias: [],
  };
};

const adicionaEvento = (promotoriaId: number, municipio: Municipios, evento: Evento) => {
  //console.log(dadosPromotoria.value);
  //console.log(evento.promotorDesignadoEvento);
  
  dadosPromotoria.value.nome = municipio.nome;
  if (evento.periodo.start && evento.periodo.end) {
    dadosPromotoria.value.promotorias.push({
      nome: municipio.promotorias[promotoriaId].nome,
      isEspecializada: municipio.promotorias[promotoriaId].isEspecializada,
      nomePromotor: municipio.promotorias[promotoriaId].nomePromotor,
      eventos: [
        {
          id: evento.id,
          tipo: evento.tipo,
          periodo: [evento.periodo.start, evento.periodo.end],
          titulo: evento.titulo,
          promotorDesignadoEvento: evento.promotorDesignadoEvento,
        },
      ],
    });
  }
  //console.log(dadosPromotoria.value);  
  emit('update:adicionaDados', dadosPromotoria.value);

  resetDadosPromotoria();
};

const deleteEventoInterior = (eventoId: number, nomePromotoria: string) => {
  emit('delete:deleteEvento', eventoId, nomePromotoria);
};

const EditaEvento = (nomePromotoria: string, evento: Evento) => {
  emit('update:editaEvento', nomePromotoria, evento);
};
</script>

<template>
  <div>
    <div class="max-w-5xl w-full mx-auto flex flex-col items-center space-y-4">
      <h1 class="text-2xl font-bold text-gray-700 dark:text-gray-200">
        Entrância Final – Santana
      </h1>
      <PlantaoCaraterUrgenciaEditor />
      <TabelaPromotoriaEditor
        :municipios="promotoriasNaoEspecializadas"
        @update:adicionaEvento="adicionaEvento"
        @delete:deleteEvento="deleteEventoInterior"
        @update:editaEvento="EditaEvento"
      />
    </div>
    <div class="max-w-5xl w-full mx-auto flex flex-col items-center space-y-4">
      <h1 class="text-2xl font-bold text-gray-700 dark:text-gray-200">
        Entrância Final – Santana (Especializadas) 
      </h1>
      <TabelaPromotoriaEditor
        :municipios="promotoriasEspecializadas"
        @update:adicionaEvento="adicionaEvento"
        @delete:deleteEvento="deleteEventoInterior"
        @update:editaEvento="EditaEvento"
      />
    </div>
  </div>
</template>