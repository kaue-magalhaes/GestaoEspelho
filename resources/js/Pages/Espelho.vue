<script setup lang="ts">
import { ref, onMounted, watch } from 'vue';
import { Head } from '@inertiajs/vue3';
import { format } from 'date-fns';
import {
    GrupoPromotoria,
    Atribuicoes,
    Espelho,
    Promotor,
    Evento,
    UrgenciaAtendimento
} from '@/types';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Preview from '@/Components/EspelhoComponents/Preview.vue';
import Editor from '@/Components/EspelhoComponents/Editor.vue';
import { Carousel, CarouselContent, CarouselItem, CarouselNext, CarouselPrevious } from '@/Components/ui/carousel';

const props = defineProps({
    espelho: {
        type: Object as () => Espelho,
        required: true,
    },
    promotores: {
        type: Array as () => Promotor[],
        required: true,
    },
    eventos: {
        type: Array as () => Evento[],
        required: true,
    },
    urgenciaAtendimentos: {
        type: Array as () => UrgenciaAtendimento[],
        required: true,
    },
});

const periodoEspelho = ref<string[]>([
    format(new Date(props.espelho?.periodo_inicio), 'dd/MM/yyyy'),
    format(new Date(props.espelho?.periodo_fim), 'dd/MM/yyyy'),
]);
const grupoDeTodasAsPromotoriasDados = ref<GrupoPromotoria[]>([]);
const atendimentosUrgenciaDados = ref([]);
const listaAtribuicoes = ref<Atribuicoes[]>([]);

const updatePeriodoEspelho = (value: string[]) => {
    if (Array.isArray(value)) {
        periodoEspelho.value = value;
    } else {
        periodoEspelho.value.push(value);
    }
};

const updateGrupoDeTodasAsPromotorias = (value: GrupoPromotoria[]) => {
    grupoDeTodasAsPromotoriasDados.value = value;
    if (value.length === 0) {
        grupoDeTodasAsPromotoriasDados.value = [];
    }
}

const updateAtribuicao = (value: Atribuicoes[]) => {
    listaAtribuicoes.value = value;
};

const updateAtendimentosUrgencia = (value: []) => {
  atendimentosUrgenciaDados.value = value;
};

onMounted(() => {
    //console.log(props.espelho);
    // console.log(props.promotores);
    // console.log(props.eventos);
    //console.log(props.urgenciaAtendimentos);
});
</script>

<template>
    <Head title="Espelho" />
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Carousel class="focus-visible:outline-none">
                    <CarouselContent>
                        <CarouselItem>
                            <Editor
                                :espelho="espelho"
                                :promotorias="espelho.promotorias"
                                :promotores="props.promotores"
                                :eventos="props.eventos"
                                :urgenciaAtendimentos="props.urgenciaAtendimentos"
                                @update:periodoEspelho="updatePeriodoEspelho"
                                @update:grupoDeTodasAsPromotorias="updateGrupoDeTodasAsPromotorias"
                                @update:dadosDosAtendimentosUrgencia="updateAtendimentosUrgencia"
                                @update:atribuicao="updateAtribuicao"
                            />
                        </CarouselItem>
                        <CarouselItem>
                            <Preview
                                :periodoEspelho="periodoEspelho"
                                :grupoPromotoriaDeTodasAsPromotorias="grupoDeTodasAsPromotoriasDados"
                                :listaAtribuicoes="listaAtribuicoes"
                                :atendimentosUrgenciaDados="atendimentosUrgenciaDados"
                            />
                        </CarouselItem>
                    </CarouselContent>
                    <CarouselPrevious />
                    <CarouselNext />
                </Carousel>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
