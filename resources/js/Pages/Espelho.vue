<script setup lang="ts">
import { Promotor, Promotoria } from '@/types';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, onMounted } from 'vue';
import { Head } from '@inertiajs/vue3';
import { Carousel, CarouselContent, CarouselItem, CarouselNext, CarouselPrevious } from '@/Components/ui/carousel';
import Preview from '@/Components/EspelhoComponents/Preview.vue';
import Editor from '@/Components/EspelhoComponents/Editor.vue';

const props = defineProps({
    promotorias: {
        type: Array as () => Promotoria[],
        required: true,
    },
    promotores: {
        type: Array as () => Promotor[],
        required: true,
    },
});

const periodoEspelho = ref<string[]>([]);
const atendimentosUrgenciaMacapa = ref<any[]>([]);
const promotoriasUpdate = ref<Promotoria[]>([]);
const listaPromotoresSubstitutosAtribuicoes = ref<{ promotor: Promotor; atribuicao: Array<string> }[]>([]);

const updatePromotorias = (value: { all: Promotoria[] }) => {
    promotoriasUpdate.value = value.all;
};

const updatePeriodoEspelho = (value: string[]) => {
    periodoEspelho.value = value;
};

const updatePromotorUrgencia = (index: number, value: string) => {
    if (!atendimentosUrgenciaMacapa.value[index]) {
        atendimentosUrgenciaMacapa.value[index] = {};
    }
    atendimentosUrgenciaMacapa.value[index].promotor = value;
};

const updatePeriodoUrgencia = (index: number, value: string) => {
    if (!atendimentosUrgenciaMacapa.value[index]) {
        atendimentosUrgenciaMacapa.value[index] = {};
    }
    atendimentosUrgenciaMacapa.value[index].periodo = value;
};

const removePromotorUrgenciaItem = (index: number) => {
    atendimentosUrgenciaMacapa.value.splice(index, 1);
};

const AdicionaNovaAtribuicao = (value: { promotor: Promotor; atribuicao: Array<string> }) => {
    listaPromotoresSubstitutosAtribuicoes.value.push(value);
};

onMounted(() => {
    //console.log(props.promotores);
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
                                @update:nova-atribuicao="AdicionaNovaAtribuicao"
                            />
                        </CarouselItem>
                        <CarouselItem>
                            <Preview
                                :listaPromotoresSubstitutosAtribuicoes="listaPromotoresSubstitutosAtribuicoes"
                                :promotorias="promotorias"
                                :periodo-espelho="periodoEspelho"
                                :atendimentos-urgencia-macapa="atendimentosUrgenciaMacapa"
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
