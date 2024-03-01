<script setup lang="ts">
import { GrupoPromotoria } from '@/types';
import { ref } from 'vue';


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
  'update:adicionaMunicipiosDados',
  'delete:deleteEventoInterior',
  'update:editaEvento',
]);

const props = defineProps({
  municipiosInterior: {
    type: Array as () => GrupoPromotoria[],
    required: true,
  },
});

const municipiosDados = ref<GrupoPromotoria>({
  nome: '',
  promotorias: [],
});

const resetMunicipiosDados = () => {
  municipiosDados.value = {
    nome: '',
    promotorias: [],
  };
};

const adicionaEvento = (promotoriaId: number, municipio: GrupoPromotoria, evento: Evento) => {
  //console.log(municipiosDados.value);
  //console.log(evento.promotor_designado_evento);
  
  municipiosDados.value.nome = municipio.nome;
  if (evento.periodo.start && evento.periodo.end) {
    municipiosDados.value.promotorias.push({
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
  //console.log(municipiosDados.value);  
  emit('update:adicionaMunicipiosDados', municipiosDados.value);

  resetMunicipiosDados();
};

const deleteEventoInterior = (eventoId: number, nomePromotoria: string) => {
  emit('delete:deleteEventoInterior', eventoId, nomePromotoria);
};

const EditaEvento = (nomePromotoria: string, evento: Evento) => {
  emit('update:editaEvento', nomePromotoria, evento);
};
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
     @update:editaEvento="EditaEvento"
    />
  </div>
</template>