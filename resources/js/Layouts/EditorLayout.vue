<script setup lang="ts">

import {Head} from "@inertiajs/vue3";
</script>

<template>
    <Head title="Espelho"/>
    <AuthenticatedLayout>
        <ContainerComponent>
            <Carousel class="focus-visible:outline-none">
                <CarouselContent>
                    <CarouselItem>
                        <slot name="editor"/>
                    </CarouselItem>
                    <CarouselItem>
                        <slot name="preview"/>
                    </CarouselItem>
                </CarouselContent>
                <CarouselPrevious/>
                <CarouselNext/>
            </Carousel>
        </ContainerComponent>
    </AuthenticatedLayout>
</template>
