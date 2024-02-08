<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import { Button } from '@/Components/ui/button';
import { Input } from '@/Components/ui/input';
import { Card, CardContent, CardHeader, CardTitle } from '@/Components/ui/card';

const rows = ref(1);
const columns = ref(1);
const tableData = ref([['']]);

const addRow = () => {
    rows.value++;
    tableData.value.push(Array(columns.value).fill(''));
};

const addColumn = () => {
    columns.value++;
    tableData.value.forEach((row, index) => {
        tableData.value[index].push('');
    });
};
</script>

<template>
    <Head title="Espelho" />
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-full mx-auto sm:px-6 lg:px-8">
                <Card>
                    <CardHeader>
                        <CardTitle class="text-lg p-4 font-semibold">
                            Área de criação do espelho
                        </CardTitle>

                        <div class="flex justify-end items-center p-4">
                            <Button @click="addRow">Adicionar linha</Button>
                            <Button class="ml-2" @click="addColumn">Adicionar coluna</Button>
                        </div>
                    </CardHeader>

                    <CardContent>
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th v-for="column in columns" :key="column" class="px-6 py-3">
                                        Coluna {{ column }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(row, rowIndex) in tableData" :key="rowIndex" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td v-for="(cell, columnIndex) in row" :key="columnIndex" class="px-6 py-4">
                                        <Input v-model="tableData[rowIndex][columnIndex]" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
