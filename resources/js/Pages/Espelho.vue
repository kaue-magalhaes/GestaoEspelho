<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Carousel, CarouselContent, CarouselItem } from '@/Components/ui/carousel';
import Preview from './Preview.vue';
import EspelhoEdit from '@/Components/EspelhoEdit.vue';

</script>

<template>
    <Head title="Espelho" />
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Carousel class="focus-visible:outline-none">
                    <CarouselContent>
                        <CarouselItem>
                            <EspelhoEdit />
                        </CarouselItem>
                        <CarouselItem>
                            <Preview />
                        </CarouselItem>
                    </CarouselContent>
                </Carousel>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
