<script setup lang="ts">
import {onMounted, ref} from 'vue';
import {Promotoria} from "@/Interfaces/Promotoria/Promotoria";
import {GrupoPromotoria} from "@/Interfaces/GrupoPromotoria/GrupoPromotoria";
import {Promotor} from "@/Interfaces/Promotor/Promotor";
import {Evento} from "@/Interfaces/Evento/Evento";

const emit = defineEmits([
    'update:novoEventoAdicionado',
    'update:umEventoFoiAlterado',
    'delete:umEventoFoiDeletado',
]);

const props = defineProps({
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

const promotoriasNaoEspecializadas = ref<Promotoria[]>(props.promotorias.filter((promotoria) =>
    !promotoria.is_especializada
));
const promotoriasEspecializadas = ref<Promotoria[]>(props.promotorias.filter((promotoria) =>
    promotoria.is_especializada
));

const grupoDePromotoriasNaoEspecializadas = ref<GrupoPromotoria[]>(props.grupoPromotorias);
const grupoDePromotoriasEspecializadas = ref<GrupoPromotoria[]>(props.grupoPromotorias);

const enviaDadosDoNovoEvento = (grupoDePromotoriaID: String, promotoriaID: String, novoEvento: Evento) => {
    emit('update:novoEventoAdicionado', grupoDePromotoriaID, promotoriaID, novoEvento);
};

const enviaDadosDoEventoAlterado = (grupoDePromotoriaID: String, promotoriaID: String, eventoAlterado: Evento) => {
    emit('update:umEventoFoiAlterado', grupoDePromotoriaID, promotoriaID, eventoAlterado);
};

const enviaDadosDoEventoDeletado = (eventoDeletado: Evento) => {
    emit('delete:umEventoFoiDeletado', eventoDeletado);
};

const filtraGrupoPromotoria = (grupoPromotorias: GrupoPromotoria[], promotoriasSelecionadas: Promotoria[]) => {
    const grupoValue: GrupoPromotoria[] = [];
    grupoPromotorias.forEach((grupo) => {
        const value = grupo.promotorias?.filter((promotoria) => promotoriasSelecionadas.some((promotoriaSelecionada) => promotoriaSelecionada.id === promotoria.id));
        if (value && value.length > 0) {
            grupoValue.push({...grupo, promotorias: value});
        }
    })
    return grupoValue;
}

onMounted(() => {
    grupoDePromotoriasNaoEspecializadas.value = filtraGrupoPromotoria(grupoDePromotoriasNaoEspecializadas.value, promotoriasNaoEspecializadas.value);
    grupoDePromotoriasEspecializadas.value = filtraGrupoPromotoria(grupoDePromotoriasEspecializadas.value, promotoriasEspecializadas.value);
});
</script>

<template>
    <div>
        <div class="max-w-5xl w-full mx-auto flex flex-col items-center space-y-4">
            <h1 class="text-2xl font-bold text-gray-700 dark:text-gray-200 mt-4">
                Entrância Final – Santana
            </h1>
            <TabelaPromotoriaEditor
                :promotores="promotores"
                :grupoPromotorias="grupoDePromotoriasNaoEspecializadas"
                @update:novoEventoAdicionado="enviaDadosDoNovoEvento"
                @update:umEventoFoiAlterado="enviaDadosDoEventoAlterado"
                @delete:umEventoFoiDeletado="enviaDadosDoEventoDeletado"
            />
        </div>
        <div class="max-w-5xl w-full mx-auto flex flex-col items-center space-y-4">
            <h1 class="text-2xl font-bold text-gray-700 dark:text-gray-200 mt-4">
                Entrância Final – Santana (Especializadas)
            </h1>
            <TabelaPromotoriaEditor
                :promotores="promotores"
                :grupoPromotorias="grupoDePromotoriasEspecializadas"
                @update:novoEventoAdicionado="enviaDadosDoNovoEvento"
                @update:umEventoFoiAlterado="enviaDadosDoEventoAlterado"
                @delete:umEventoFoiDeletado="enviaDadosDoEventoDeletado"
            />
        </div>
    </div>
</template>
