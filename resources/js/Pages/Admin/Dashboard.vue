<script setup lang="ts">
import {Head} from "@inertiajs/vue3";

</script>

<template>
    <Head title="Espelho" />
    <AuthenticatedLayout>
        <ContainerComponent>
            <div class="flex justify-between">
                <h1 class="text-2xl font-semibold text-gray-900">Dashboard</h1>
            </div>
        </ContainerComponent>
    </AuthenticatedLayout>
</template>
