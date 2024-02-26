<script setup lang="ts">
import { Promotoria } from '@/types';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import { Carousel, CarouselContent, CarouselItem, CarouselNext, CarouselPrevious } from '@/Components/ui/carousel';
import Preview from '@/Components/EspelhoComponents/Preview.vue';
import Editor from '@/Components/EspelhoComponents/Editor.vue';

const periodoEspelho = ref<string[]>([]);
const promotorias = ref<Promotoria[]>([]);

const atendimentosUrgenciaMacapa = ref<any[]>([]);

const updatePromotorias = (value: { all: Promotoria[] }) => {
    promotorias.value = value.all;
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
                                @update:promotorias="updatePromotorias"
                                @update:periodo-espelho="updatePeriodoEspelho"
                                @update:promotor-urgencia="updatePromotorUrgencia"
                                @update:periodo-urgencia="updatePeriodoUrgencia"
                                @remove:promotor-urgencia-item="removePromotorUrgenciaItem"
                            />
                        </CarouselItem>
                        <CarouselItem>
                            <Preview
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
