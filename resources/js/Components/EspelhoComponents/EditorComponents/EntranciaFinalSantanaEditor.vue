<script setup lang="ts">
import { GrupoPromotoria } from '@/types';
import { ref, onMounted } from 'vue';


import TabelaPromotoriaEditor from '@/Components/EspelhoComponents/EditorComponents/TabelaPromotoriaEditor.vue';

type Evento = {
  id: number;
  tipo: string;
  periodo:{
    start: Date | null;
    end: Date | null;
  };
  titulo: string;
  promotor_designado_evento: string;
};

const emit = defineEmits([
  'update:adicionaDados',
  'delete:deleteEvento',
  'update:editaEvento',
]);

const props = defineProps({
  promotoriasSantana: {
    type: Array as () => GrupoPromotoria[],
    required: true,
  },
});

const promotoriasNaoEspecializadas = ref<GrupoPromotoria[]>([]);
const promotoriasEspecializadas = ref<GrupoPromotoria[]>([]);

const dadosPromotoria = ref<GrupoPromotoria>({
  nome: '',
  promotorias: [],
});

const resetDadosPromotoria = () => {
  dadosPromotoria.value = {
    nome: '',
    promotorias: [],
  };
};

const adicionaEvento = (promotoriaId: number, municipio: GrupoPromotoria, evento: Evento) => {
  //console.log(dadosPromotoria.value);
  //console.log(evento.promotor_designado_evento);
  
  dadosPromotoria.value.nome = municipio.nome;
  if (evento.periodo.start && evento.periodo.end) {
    dadosPromotoria.value.promotorias.push({
      nome: municipio.promotorias[promotoriaId].nome,
      is_especializada: municipio.promotorias[promotoriaId].is_especializada,
      nomePromotor: municipio.promotorias[promotoriaId].nomePromotor,
      eventos: [
        {
          id: evento.id,
          tipo: evento.tipo,
          periodo: [evento.periodo.start, evento.periodo.end],
          titulo: evento.titulo,
          promotor_designado_evento: evento.promotor_designado_evento,
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

onMounted(() => {
  console.log(props.promotoriasSantana);
  props.promotoriasSantana.forEach((grupoPromotoria) => {
    grupoPromotoria.promotorias.forEach((promotoria) => {
      if (promotoria.is_especializada) {
        console.log('especializada -> ' + grupoPromotoria);
      } else {
        console.log('não especializada -> ' + grupoPromotoria);
      }
    });
  });
  //console.log(promotoriasNaoEspecializadas.value);
  //console.log(promotoriasEspecializadas.value);
});
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