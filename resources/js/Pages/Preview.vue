<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Card, CardHeader } from '@/Components/ui/card';
</script>

<template>
    <Head title="Preview" />
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-full mx-auto sm:px-6 lg:px-8">
                <Card>
                    <CardHeader>
                        <div class="flex justify-center items-center">
                            <div class="flex flex-col items-center">
                                <div class="flex flex-col items-center">
                                    <a href="https://www.mpap.mp.br" target="_blank" class="flex flex-col items-center">
                                        <div class="h-16 w-auto sm:h-20">
                                            <img
                                            class="h-16 w-auto sm:h-20" 
                                            src="https://www.mpap.mp.br/templates/portal/images/logo-mpap.png"
                                            >
                                        </div>
                                        <h1 class="font-bold text-gray-700 dark:text-gray-200">
                                            Procuradoria Geral de Justiça
                                        </h1>
                                    </a>

                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        Procuradorias de Justiça do Estado do Amapá
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        Espelho de 07/02/2024 a 15/02/2024
                                    </div>

                                    <div>
                                        <!-- Pequena tabela sobre o PLANTÃO DE MACAPÁ PARA ATENDIMENTOS EM CARÁTER DE URGÊNCIA -->
                                    </div>

                                    <div>
                                        <!-- Tabela das Procuradorias de Justiça de Entrância Final - Macapá -->
                                    </div>

                                    <div>
                                        <!-- Tabela das Procuradorias de Justiça de Entrância Final - Macapá (Especializadas) -->
                                    </div>

                                    <div>
                                        <!-- Pequena tabela sobre o PLANTÃO DE MACAPÁ PARA ATENDIMENTOS EM CARÁTER DE URGÊNCIA (Novamente) -->
                                    </div>
                                    <div>
                                        <!-- Tabela das Procuradorias de Justiça de Entrância Final - Santana -->
                                    </div>

                                    <div>
                                        <!-- Tabela das Procuradorias de Justiça de Entrância Inicial - Interiores -->
                                    </div>

                                    <div>
                                        <!-- Promotores de Justiça Substitutos -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </CardHeader>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
