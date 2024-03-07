<script setup lang="ts">
import { Evento, GrupoPromotoria, Promotor, Promotoria } from '@/types';
import TabelaPromotoriaEditor from '@/Components/EspelhoComponents/EditorComponents/TabelaPromotoriaEditor.vue';

const emit = defineEmits([
  'update:novoEventoAdicionado',
  'update:umEventoFoiAlterado',
  'delete:umEventoFoiDeletado',
  'update:grupoPromotorias'
]);

defineProps({
  promotoriasInterior: {
    type: Array as () => Promotoria[],
    required: true,
  },
  promotores: {
    type: Array as () => Promotor[],
    required: true,
  },
});

const enviaDadosDoNovoEvento = (nomeDoGrupoDePromotorias: string, novoEvento: Evento) => {
  emit('update:novoEventoAdicionado', nomeDoGrupoDePromotorias, novoEvento);
};

const enviaDadosDoEventoAlterado = (eventoAlterado: Evento) => {
  emit('update:umEventoFoiAlterado', eventoAlterado);
};

const enviaDadosDoEventoDeletado = (eventoDeletadoId: number) => {
  emit('delete:umEventoFoiDeletado', eventoDeletadoId);
};

const enviaDadosDoGrupoDePromotorias = (grupoPromotorias: GrupoPromotoria[]) => {
  emit('update:grupoPromotorias', grupoPromotorias);
};
</script>

<template>
  <div class="max-w-5xl w-full mx-auto flex flex-col items-center space-y-4">
    <h1 class="text-2xl font-bold text-gray-700 dark:text-gray-200 mt-4">
      Entrância Inicial
    </h1>
    <TabelaPromotoriaEditor
      :promotorias="promotoriasInterior"
      @update:novoEventoAdicionado="enviaDadosDoNovoEvento"
      @update:UmEventoFoiAlterado="enviaDadosDoEventoAlterado"
      @delete:umEventoFoiDeletado="enviaDadosDoEventoDeletado"
      @update:grupoPromotorias="enviaDadosDoGrupoDePromotorias"
    />
  </div>
</template>