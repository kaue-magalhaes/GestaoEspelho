<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import { Carousel, CarouselContent, CarouselItem } from '@/Components/ui/carousel';
import Preview from '@/Components/Preview.vue';
import EspelhoEdit from '@/Components/EspelhoEdit.vue';

const periodo = ref(null);

const updatePeriodo = (value) => {
    console.log(value);
  periodo.value = value;
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
                                @update:periodo="updatePeriodo"
                            />
                        </CarouselItem>
                        <CarouselItem>
                            <Preview
                                :periodo="periodo"
                            />
                        </CarouselItem>
                    </CarouselContent>
                </Carousel>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
