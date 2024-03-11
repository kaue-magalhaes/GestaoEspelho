<script setup lang="ts">
import {Evento, GrupoPromotoria, Promotor, Promotoria} from '@/types';
import { ref } from 'vue';

import PlantaoCaraterUrgenciaEditor from '@/Components/EspelhoComponents/EditorComponents/PlantaoCaraterUrgenciaEditor.vue';
import TabelaPromotoriaEditor from '@/Components/EspelhoComponents/EditorComponents/TabelaPromotoriaEditor.vue';

const emit = defineEmits([
  'update:novoEventoAdicionado',
  'update:umEventoFoiAlterado',
  'delete:umEventoFoiDeletado',
  'update:nomeFoiSelecionado',
  'update:periodoDoAtendimentoFoiSelecionado',
  'delete:inputDeDadosFoiDeletado',
  'update:grupoPromotorias'
]);

const props = defineProps({
  promotoriasMacapa: {
    type: Array as () => Promotoria[],
    required: true,
  },
  eventos: {
    type: Array as () => Evento[],
    required: true,
  },
  promotores: {
    type: Array as () => Promotor[],
    required: true,
  },
});

const promotoriasNaoEspecializadas = ref<Promotoria[]>(props.promotoriasMacapa?.filter((promotoria) => !promotoria.is_especializada));
const promotoriasEspecializadas = ref<Promotoria[]>(props.promotoriasMacapa?.filter((promotoria) => promotoria.is_especializada));

const enviaDadosDoNovoEvento = (nomeDoGrupoDePromotorias: string, novoEvento: Evento) => {
  emit('update:novoEventoAdicionado', nomeDoGrupoDePromotorias, novoEvento);
};

const enviaDadosDoEventoAlterado = (eventoAlterado: Evento) => {
  emit('update:umEventoFoiAlterado', eventoAlterado);
};

const enviaDadosDoEventoDeletado = (uuid: string) => {
  emit('delete:umEventoFoiDeletado', uuid);
};

const enviaNomeDoPromotorSelecionado = (index: number, idPromotor: string) => {  
  emit('update:nomeFoiSelecionado', index, idPromotor);
};

const enviaPeriodoDoAtendimentoSelecionado = (index : number, periodo_start: string, periodo_end: string) => {
  emit('update:periodoDoAtendimentoFoiSelecionado', index, periodo_start, periodo_end);
};

const enviaIndexInputDeDadosDeletado = (index: number) => {
  emit('delete:inputDeDadosFoiDeletado', index);
};

const enviaDadosDoGrupoDePromotorias = (grupoPromotorias: GrupoPromotoria[]) => {
  emit('update:grupoPromotorias', grupoPromotorias);
};
</script>

<template>
  <div>
    <div class="max-w-5xl w-full mx-auto flex flex-col items-center space-y-4">
      <h1 class="text-2xl font-bold text-gray-700 dark:text-gray-200 mt-4">
        Entrância Final – Macapá
      </h1>
      <PlantaoCaraterUrgenciaEditor
        @delete:inputDeDadosFoiDeletado="enviaIndexInputDeDadosDeletado"
        @update:nomeFoiSelecionado="enviaNomeDoPromotorSelecionado"
        @update:periodoDoAtendimentoFoiSelecionado="enviaPeriodoDoAtendimentoSelecionado"
      />
      <TabelaPromotoriaEditor
        :promotorias="promotoriasNaoEspecializadas"
        :eventos="props.eventos"
        @update:novoEventoAdicionado="enviaDadosDoNovoEvento"
        @update:UmEventoFoiAlterado="enviaDadosDoEventoAlterado"
        @delete:umEventoFoiDeletado="enviaDadosDoEventoDeletado"
        @update:grupoPromotorias="enviaDadosDoGrupoDePromotorias"
      />
    </div>
    <div class="max-w-5xl w-full mx-auto flex flex-col items-center space-y-4">
      <h1 class="text-2xl font-bold text-gray-700 dark:text-gray-200 mt-4">
        Entrância Final – Macapá (Especializadas)
      </h1>
      <TabelaPromotoriaEditor
        :promotorias="promotoriasEspecializadas"
        :eventos="props.eventos"
        @update:novoEventoAdicionado="enviaDadosDoNovoEvento"
        @update:UmEventoFoiAlterado="enviaDadosDoEventoAlterado"
        @delete:umEventoFoiDeletado="enviaDadosDoEventoDeletado"
        @update:grupoPromotorias="enviaDadosDoGrupoDePromotorias"
      />
    </div>
  </div>
</template>
