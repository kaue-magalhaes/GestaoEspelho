<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { Button } from "@/components/ui/button";
import { Input } from "@/Components/ui/input";
import { Card, CardContent, CardHeader, CardTitle } from "@/Components/ui/card";

import Calendar from "primevue/calendar";
import { ref } from "vue";

const dates = ref();

const form = useForm({
    nome: "",
    conteudo: "",
    dates: null,
});

const submit = () => {
    form.dates = dates.value;
    form.post(route("document.create"));
};
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

                    <CardContent>
                        <div class="flex flex-col space-y-4">
                            <Input
                                v-model="form.nome"
                                label="Nome"
                                class="w-1/2"
                            />
                            <Calendar
                                v-model="dates"
                                selectionMode="range"
                                :manualInput="false"
                                class="w-1/2"
                            />
                            <Input
                                v-model="form.conteudo"
                                label="Conteúdo"
                                class="w-1/2"
                            />

                            <Button
                                class="mt-4"
                                @click="submit"
                            >
                                Salvar
                            </Button>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
