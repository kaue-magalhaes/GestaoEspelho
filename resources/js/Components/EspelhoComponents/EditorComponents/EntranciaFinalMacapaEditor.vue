<script setup lang="ts">
import { GrupoPromotoria } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { ref, onBeforeMount } from 'vue';
import { format } from 'date-fns';


import PlantaoCaraterUrgenciaEditor from '@/Components/EspelhoComponents/EditorComponents/PlantaoCaraterUrgenciaEditor.vue';
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

const promotores = usePage().props.promotores;

const emit = defineEmits([
  'update:adicionaDados',
  'update:editaEvento',
  'delete:deleteEvento',
  'update:NomePromotor',
  'update:Periodo',
  'delete:atendimentosUrgencia',
]);

const props = defineProps({
  promotorias: {
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
      municipio: municipio.promotorias[promotoriaId].municipio,
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

const deletaEvento = (eventoId: number, nomePromotoria: string) => {
  emit('delete:deleteEvento', eventoId, nomePromotoria);
};

const editaEvento = (nomePromotoria: string, evento: Evento) => {
  emit('update:editaEvento', nomePromotoria, evento);
};

const adicionaNomePromotor = (id: number, nome: string) => {
  //console.log(id, nome);
  emit('update:NomePromotor', id , nome);
};

const adicionaPeriodoAtendimento = (id : number, periodo: { start: Date ; end: Date }) => {
  //console.log(id, periodo);
  let periodoFormatado = {
    start: format(periodo.start, 'dd/MM/yyyy'),
    end: format(periodo.end, 'dd/MM/yyyy'),
  };
  emit('update:Periodo', id, periodoFormatado);
};

const removeAtendimentoUrgencia = (index: number) => {
  emit('delete:atendimentosUrgencia', index);
};

onBeforeMount(() => {
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
  <div>
    <div class="max-w-5xl w-full mx-auto flex flex-col items-center space-y-4">
      <h1 class="text-2xl font-bold text-gray-700 dark:text-gray-200 mt-4">
        Entrância Final – Macapá
      </h1>
      <PlantaoCaraterUrgenciaEditor
        :promotores="promotores"
        @update:promotorNome="adicionaNomePromotor"
        @update:periodoAtendimento="adicionaPeriodoAtendimento"
        @remove:atendimentoUrgenciaValues="removeAtendimentoUrgencia"
      />
      <TabelaPromotoriaEditor
        :municipios="promotoriasNaoEspecializadas"
        @update:adicionaEvento="adicionaEvento"
        @delete:deleteEvento="deletaEvento"
        @update:editaEvento="editaEvento"
      />
    </div>
    <div class="max-w-5xl w-full mx-auto flex flex-col items-center space-y-4">
      <h1 class="text-2xl font-bold text-gray-700 dark:text-gray-200 mt-4">
        Entrância Final – Macapá (Especializadas) 
      </h1>
      <TabelaPromotoriaEditor
        :municipios="promotoriasEspecializadas"
        @update:adicionaEvento="adicionaEvento"
        @delete:deleteEvento="deletaEvento"
        @update:editaEvento="editaEvento"
      />
    </div>
  </div>
</template>