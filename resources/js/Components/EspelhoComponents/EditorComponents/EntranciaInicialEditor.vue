<script setup lang="ts">
import {EventoClientSide} from "@/Interfaces/EventoClientSide";
import {GrupoPromotoria} from "@/Interfaces/GrupoPromotoria";
import {Promotoria} from "@/Interfaces/Promotoria";
import {Promotor} from "@/Interfaces/Promotor";

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

const enviaDadosDoNovoEvento = (nomeDoGrupoDePromotorias: string, novoEvento: EventoClientSide) => {
  emit('update:novoEventoAdicionado', nomeDoGrupoDePromotorias, novoEvento);
};

const enviaDadosDoEventoAlterado = (eventoAlterado: EventoClientSide) => {
  emit('update:umEventoFoiAlterado', eventoAlterado);
};

const enviaDadosDoEventoDeletado = (uuid: string) => {
  emit('delete:umEventoFoiDeletado', uuid);
};

const enviaDadosDoGrupoDePromotorias = (grupoPromotorias: GrupoPromotoria[], eventos: EventoClientSide[]) => {
  emit('update:grupoPromotorias', grupoPromotorias, eventos);
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
