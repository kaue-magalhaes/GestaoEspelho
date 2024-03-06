<script setup lang="ts">
import { Evento, Promotoria } from '@/types';
import { ref } from 'vue';
import TabelaPromotoriaEditor from '@/Components/EspelhoComponents/EditorComponents/TabelaPromotoriaEditor.vue';

const emit = defineEmits([
  'update:novoEventoAdicionado',
  'update:umEventoFoiAlterado',
  'delete:umEventoFoiDeletado',
]);

const props = defineProps({
  promotoriasSantana: {
    type: Array as () => Promotoria[],
    required: true,
  },
});

const promotoriasNaoEspecializadas = ref<Promotoria[]>(props.promotoriasSantana?.filter((promotoria) => !promotoria.is_especializada));
const promotoriasEspecializadas = ref<Promotoria[]>(props.promotoriasSantana?.filter((promotoria) => promotoria.is_especializada));

const enviaDadosDoNovoEvento = (nomeDoGrupoDePromotorias: string, novoEvento: Evento) => {
  emit('update:novoEventoAdicionado', nomeDoGrupoDePromotorias, novoEvento);
};

const enviaDadosDoEventoAlterado = (eventoAlterado: Evento) => {
  emit('update:umEventoFoiAlterado', eventoAlterado);
};

const enviaDadosDoEventoDeletado = (eventoDeletadoId: number, ) => {
  emit('delete:umEventoFoiDeletado', eventoDeletadoId);
};
</script>

<template>
  <div>
    <div class="max-w-5xl w-full mx-auto flex flex-col items-center space-y-4">
      <h1 class="text-2xl font-bold text-gray-700 dark:text-gray-200 mt-4">
        Entrância Final – Santana
      </h1>
      <TabelaPromotoriaEditor
        :promotorias="promotoriasNaoEspecializadas"
        @update:novoEventoAdicionado="enviaDadosDoNovoEvento"
        @update:UmEventoFoiAlterado="enviaDadosDoEventoAlterado"
        @delete:umEventoFoiDeletado="enviaDadosDoEventoDeletado"
      />
    </div>
    <div class="max-w-5xl w-full mx-auto flex flex-col items-center space-y-4">
      <h1 class="text-2xl font-bold text-gray-700 dark:text-gray-200 mt-4">
        Entrância Final – Santana (Especializadas) 
      </h1>
      <TabelaPromotoriaEditor
        :promotorias="promotoriasEspecializadas"
        @update:novoEventoAdicionado="enviaDadosDoNovoEvento"
        @update:UmEventoFoiAlterado="enviaDadosDoEventoAlterado"
        @delete:umEventoFoiDeletado="enviaDadosDoEventoDeletado"
      />
    </div>
  </div>
</template>