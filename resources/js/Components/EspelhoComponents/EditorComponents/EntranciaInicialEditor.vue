<script setup lang="ts">
import {GrupoPromotoria} from "@/Interfaces/GrupoPromotoria/GrupoPromotoria";
import {Promotoria} from "@/Interfaces/Promotoria/Promotoria";
import {Promotor} from "@/Interfaces/Promotor/Promotor";
import {Evento} from "@/Interfaces/Evento/Evento";

const emit = defineEmits([
    'update:novoEventoAdicionado',
    'update:umEventoFoiAlterado',
    'delete:umEventoFoiDeletado',
]);

defineProps({
    grupoPromotorias: {
        type: Array as () => GrupoPromotoria[],
        required: true,
    },
    promotorias: {
        type: Array as () => Promotoria[],
        required: true,
    },
    promotores: {
        type: Array as () => Promotor[],
        required: true,
    },
});

const enviaDadosDoNovoEvento = (grupoDePromotoriaID: String, promotoriaID: String, novoEvento: Evento) => {
    emit('update:novoEventoAdicionado', grupoDePromotoriaID, promotoriaID, novoEvento);
};

const enviaDadosDoEventoAlterado = (grupoDePromotoriaID: String, promotoriaID: String, eventoAlterado: Evento) => {
    emit('update:umEventoFoiAlterado', grupoDePromotoriaID, promotoriaID, eventoAlterado);
};

const enviaDadosDoEventoDeletado = (eventoDeletado: Evento) => {
    emit('delete:umEventoFoiDeletado', eventoDeletado);
}
</script>

<template>
    <div class="max-w-5xl w-full mx-auto flex flex-col items-center space-y-4">
        <h1 class="text-2xl font-bold text-gray-700 dark:text-gray-200 mt-4">
            Entrância Inicial
        </h1>
        <TabelaPromotoriaEditor
            :promotores="promotores"
            :grupoPromotorias="grupoPromotorias"
            @update:novoEventoAdicionado="enviaDadosDoNovoEvento"
            @update:umEventoFoiAlterado="enviaDadosDoEventoAlterado"
            @delete:umEventoFoiDeletado="enviaDadosDoEventoDeletado"
        />
    </div>
</template>
