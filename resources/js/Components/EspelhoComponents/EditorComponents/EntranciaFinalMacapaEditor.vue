<script setup lang="ts">
import {Promotoria} from "@/Interfaces/Promotoria";
import {EventoClientSide} from "@/Interfaces/EventoClientSide";
import {Promotor} from "@/Interfaces/Promotor";
import {GrupoPromotoria} from "@/Interfaces/GrupoPromotoria";

import {onMounted, ref} from "vue";

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
    grupoPromotorias: Array as () => GrupoPromotoria[],
    promotorias: {
        type: Array as () => Promotoria[],
        required: true,
    },
    promotores: {
        type: Array as () => Promotor[],
        required: true,
    },
});

const promotoriasMacapa= ref<Promotoria[]>(props.promotorias);

const promotoriasNaoEspecializadas = ref<Promotoria[]>(promotoriasMacapa.value.filter((promotoria) =>
    !promotoria.is_especializada
));
const promotoriasEspecializadas = ref<Promotoria[]>(promotoriasMacapa.value.filter((promotoria) =>
    promotoria.is_especializada
));

const enviaDadosDoNovoEvento = (nomeDoGrupoDePromotorias: string, novoEvento: EventoClientSide) => {
    emit('update:novoEventoAdicionado', nomeDoGrupoDePromotorias, novoEvento);
};

const enviaDadosDoEventoAlterado = (eventoAlterado: EventoClientSide) => {
    emit('update:umEventoFoiAlterado', eventoAlterado);
};

const enviaDadosDoEventoDeletado = (uuid: string) => {
    emit('delete:umEventoFoiDeletado', uuid);
};

const enviaNomeDoPromotorSelecionado = (index: number, idPromotor: string) => {
    emit('update:nomeFoiSelecionado', index, idPromotor);
};

const enviaPeriodoDoAtendimentoSelecionado = (index: number, periodo_start: string, periodo_end: string) => {
    emit('update:periodoDoAtendimentoFoiSelecionado', index, periodo_start, periodo_end);
};

const enviaIndexInputDeDadosDeletado = (index: number) => {
    emit('delete:inputDeDadosFoiDeletado', index);
};

const enviaDadosDoGrupoDePromotorias = (grupoPromotorias: GrupoPromotoria[]) => {
    emit('update:grupoPromotorias', grupoPromotorias);
};

onMounted(() => {
    //console.log(props.grupoPromotorias);
});
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
                :grupoPromotorias="grupoPromotorias"
                :promotorias="promotoriasNaoEspecializadas"
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
                :grupoPromotorias="grupoPromotorias"
                :promotorias="promotoriasEspecializadas"
                @update:novoEventoAdicionado="enviaDadosDoNovoEvento"
                @update:UmEventoFoiAlterado="enviaDadosDoEventoAlterado"
                @delete:umEventoFoiDeletado="enviaDadosDoEventoDeletado"
                @update:grupoPromotorias="enviaDadosDoGrupoDePromotorias"
            />
        </div>
    </div>
</template>
