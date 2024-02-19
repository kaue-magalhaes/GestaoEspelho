<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import { Carousel, CarouselContent, CarouselItem } from '@/Components/ui/carousel';
import Preview from '@/Components/Preview.vue';
import EspelhoEdit from '@/Components/EspelhoEdit.vue';

const periodoEspelho = ref(null);

const atendimentosUrgenciaMacapa = ref([]);

const updatePeriodoEspelho = (value) => {
    periodoEspelho.value = value;
};

const updatePromotorUrgencia = (index, value) => {
    if (!atendimentosUrgenciaMacapa.value[index]) {
        atendimentosUrgenciaMacapa.value[index] = {};
    }
    atendimentosUrgenciaMacapa.value[index].promotor = value;
};

const updatePeriodoUrgencia = (index, value) => {
    if (!atendimentosUrgenciaMacapa.value[index]) {
        atendimentosUrgenciaMacapa.value[index] = {};
    }
    atendimentosUrgenciaMacapa.value[index].periodo = value;
};

const removePromotorUrgenciaItem = (index) => {
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
                            <EspelhoEdit
                                @update:periodo-espelho="updatePeriodoEspelho"
                                @update:promotor-urgencia="updatePromotorUrgencia"
                                @update:periodo-urgencia="updatePeriodoUrgencia"
                                @remove:promotor-urgencia-item="removePromotorUrgenciaItem"
                            />
                        </CarouselItem>
                        <CarouselItem>
                            <Preview
                                :periodo-espelho="periodoEspelho"
                                :atendimentos-urgencia-macapa="atendimentosUrgenciaMacapa"
                            />
                        </CarouselItem>
                    </CarouselContent>
                </Carousel>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
