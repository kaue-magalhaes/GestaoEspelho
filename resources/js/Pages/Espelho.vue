<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Card, CardHeader, CardTitle } from '@/Components/ui/card';
</script>

<template>
    <Head title="Espelho" />
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Card>
                    <CardHeader>
                        <CardTitle class="text-lg p-4 font-semibold">
                            Área de criação do espelho
                        </CardTitle>
                    </CardHeader>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
