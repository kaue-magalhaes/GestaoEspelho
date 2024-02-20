<script setup>
import { Card, CardHeader } from '@/Components/ui/card';

const props = defineProps({
    periodoEspelho: Array,
    atendimentosUrgenciaMacapa: Object,
});
</script>

<template>
    <Card>
        <CardHeader>
            <div class="w-full flex justify-center items-center">
                <div class="w-full flex flex-col items-center space-y-16">
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
                        <div v-if="periodoEspelho" class="text-sm text-gray-500 dark:text-gray-400">
                            Espelho de {{ periodoEspelho[0] }} a {{ periodoEspelho[1] }}
                        </div>
                    </div>

                    <div v-if="atendimentosUrgenciaMacapa.length" class="max-w-5xl w-full flex flex-col items-center space-y-4">
                        <div class="text-xl font-bold text-gray-700 dark:text-gray-200 mb-2">
                            PROMOTORIAS DE JUSTIÇA DE ENTRÂNCIA FINAL – MACAPÁ
                        </div>

                        <!-- Pequena tabela sobre o PLANTÃO DE MACAPÁ PARA ATENDIMENTOS EM CARÁTER DE URGÊNCIA -->
                        <div v-if="atendimentosUrgenciaMacapa.length" class="w-full border-2 border-black p-4 rounded-md">
                            <div class="w-full flex flex-col items-center">
                                <h2 class="text-xl font-bold mb-4">PLANTÃO DE MACAPÁ PARA ATENDIMENTOS EM CARÁTER DE URGÊNCIA</h2>
                                <ul>
                                    <ul class="grid grid-cols-2 gap-4">
                                        <li class="mb-2 text-left" v-for="atendimento in atendimentosUrgenciaMacapa" :key="atendimento.promotor">
                                            <span class="font-semibold"> - {{ atendimento.promotor }}</span> <span> ({{ atendimento.periodo }}).</span>
                                        </li>
                                    </ul>
                                </ul>
                            </div>
                        </div>
                        
                        <!-- Tabela das Procuradorias de Justiça de Entrância Final - Macapá -->
                        <table class="w-full text-black">
                            <thead class="text-xs text-black uppercase bg-gray-300 border-x border-t">
                                <tr class="text-center text-base">
                                    <th class="px-6 py-4">
                                        PROMOTORIAS DE MACAPÁ
                                    </th>
                                    <th class="px-6 py-3">
                                        Promotor(a)
                                    </th>
                                    <th class="px-6 py-3">
                                        Período
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <tr class="bg-white hover:bg-gray-50 border" v-for="promotoria in $page.props.promotorias.all" :key="promotoria.id">
                                    <th class="px-6 py-4 font-medium whitespace-nowrap">
                                        <div class="flex flex-col items-center">
                                            <h1 class="font-bold text-gray-900 dark:text-gray-200">
                                                {{ promotoria.nome }}
                                            </h1>
                                        </div>
                                    </th>
                                    <td class="px-6 py-4">
                                        <h1 class="font-bold text-gray-900 dark:text-gray-200">
                                            {{ promotoria.promotor.nome }}
                                        </h1>
                                    </td>
                                    <td class="px-6 py-4">
                                        <h1 class="font-bold text-gray-900 dark:text-gray-200">
                                            Reunião CNMP
                                        </h1>
                                        <p class="text-xs">
                                            04/02/2024 - 06/02/2024
                                        </p>
                                        <p class="text-xs text-red-500">
                                            Designada Dra. Marcela (resp.)
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="max-w-5xl w-full flex flex-col items-center space-y-4">
                        <div class="text-xl font-bold text-gray-700 dark:text-gray-200 mb-2">
                            PROMOTORIAS DE JUSTIÇA DE ENTRÂNCIA FINAL – MACAPÁ (PROMOTORIAS ESPECIALIZADAS)
                        </div>
                        
                        <!-- Tabela das Procuradorias de Justiça de Entrância Final - Macapá -->
                        <table class="w-full text-black">
                            <thead class="text-xs text-black uppercase bg-gray-300 border-x border-t">
                                <tr class="text-center text-base">
                                    <th class="px-6 py-4">
                                        Execução Penal e de Medidas Alternativas
                                    </th>
                                    <th class="px-6 py-3">
                                        Promotor(a)
                                    </th>
                                    <th class="px-6 py-3">
                                        Período
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <tr class="bg-white hover:bg-gray-50 border">
                                    <th class="px-6 py-4 font-medium whitespace-nowrap">
                                        <div class="flex flex-col items-center">
                                            1ª PJ de Execução Penal e de Medidas Alternativas
                                        </div>
                                    </th>
                                    <td class="px-6 py-4">
                                        <h1 class="font-bold text-gray-900 dark:text-gray-200">
                                            Dra. Eliana Mena Cavalcante
                                        </h1>
                                        <p class="text-xs">
                                            (Coordenadora PJ Cíveis-Port. 040/2012)
                                        </p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <h1 class="font-bold text-gray-900 dark:text-gray-200">
                                            Reunião CNMP
                                        </h1>
                                        <p class="text-xs">
                                            04/02/2024 - 06/02/2024
                                        </p>
                                        <p class="text-xs text-red-500">
                                            Designada Dra. Marcela (resp.)
                                        </p>
                                    </td>
                                </tr>
                                <tr class="bg-white hover:bg-gray-50 border">
                                    <th class="px-6 py-4 font-medium whitespace-nowrap">
                                        <div class="flex flex-col items-center">
                                            2ª PJ de Execução Penal e de Medidas Alternativas
                                        </div>
                                    </th>
                                    <td class="px-6 py-4">
                                        <h1 class="font-bold text-gray-700 dark:text-gray-200">
                                            Dra. Eliana Mena Cavalcante
                                        </h1>
                                        <p class="text-xs">
                                            (Coordenadora PJ Cíveis-Port. 040/2012)
                                        </p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <h1 class="font-bold text-gray-700 dark:text-gray-200">
                                            Reunião CNMP
                                        </h1>
                                        <p class="text-xs">
                                            04/02/2024 - 06/02/2024
                                        </p>
                                        <p class="text-xs text-red-500">
                                            Designada Dra. Marcela (resp.)
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="w-full text-black">
                            <thead class="text-xs text-black uppercase bg-gray-300 border-x border-t">
                                <tr class="text-center text-base">
                                    <th class="px-6 py-4">
                                        Juizados Especiais Cíveis e Criminais
                                    </th>
                                    <th class="px-6 py-3">
                                        Promotor(a)
                                    </th>
                                    <th class="px-6 py-3">
                                        Período
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <tr class="bg-white hover:bg-gray-50 border">
                                    <th class="px-6 py-4 font-medium whitespace-nowrap">
                                        <div class="flex flex-col items-center">
                                            1ª PJ dos Juizados Especiais Cíveis e Criminais
                                        </div>
                                    </th>
                                    <td class="px-6 py-4">
                                        <h1 class="font-bold text-gray-900 dark:text-gray-200">
                                            Dra. Eliana Mena Cavalcante
                                        </h1>
                                        <p class="text-xs">
                                            (Coordenadora PJ Cíveis-Port. 040/2012)
                                        </p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <h1 class="font-bold text-gray-900 dark:text-gray-200">
                                            Reunião CNMP
                                        </h1>
                                        <p class="text-xs">
                                            04/02/2024 - 06/02/2024
                                        </p>
                                        <p class="text-xs text-red-500">
                                            Designada Dra. Marcela (resp.)
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="w-full text-black">
                            <thead class="text-xs text-black uppercase bg-gray-300 border-x border-t">
                                <tr class="text-center text-base">
                                    <th class="px-6 py-4">
                                        Infância e da Juventude
                                    </th>
                                    <th class="px-6 py-3">
                                        Promotor(a)
                                    </th>
                                    <th class="px-6 py-3">
                                        Período
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <tr class="bg-white hover:bg-gray-50 border">
                                    <th class="px-6 py-4 font-medium whitespace-nowrap">
                                        <div class="flex flex-col items-center">
                                            1ª PJ de Defesa dos Direitos da Infância e da Juventude - Cível e Administrativa
                                        </div>
                                    </th>
                                    <td class="px-6 py-4">
                                        <h1 class="font-bold text-gray-900 dark:text-gray-200">
                                            Dra. Eliana Mena Cavalcante
                                        </h1>
                                        <p class="text-xs">
                                            (Coordenadora PJ Cíveis-Port. 040/2012)
                                        </p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <h1 class="font-bold text-gray-900 dark:text-gray-200">
                                            Reunião CNMP
                                        </h1>
                                        <p class="text-xs">
                                            04/02/2024 - 06/02/2024
                                        </p>
                                        <p class="text-xs text-red-500">
                                            Designada Dra. Marcela (resp.)
                                        </p>
                                    </td>
                                </tr>
                                <tr class="bg-white hover:bg-gray-50 border">
                                    <th class="px-6 py-4 font-medium whitespace-nowrap">
                                        <div class="flex flex-col items-center">
                                            2ª PJ de Defesa dos Direitos da Infância e da Juventude - Políticas Públicas
                                        </div>
                                    </th>
                                    <td class="px-6 py-4">
                                        <h1 class="font-bold text-gray-900 dark:text-gray-200">
                                            Dra. Eliana Mena Cavalcante
                                        </h1>
                                        <p class="text-xs">
                                            (Coordenadora PJ Cíveis-Port. 040/2012)
                                        </p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <h1 class="font-bold text-gray-900 dark:text-gray-200">
                                            Reunião CNMP
                                        </h1>
                                        <p class="text-xs">
                                            04/02/2024 - 06/02/2024
                                        </p>
                                        <p class="text-xs text-red-500">
                                            Designada Dra. Marcela (resp.)
                                        </p>
                                    </td>
                                </tr>
                                <tr class="bg-white hover:bg-gray-50 border">
                                    <th class="px-6 py-4 font-medium whitespace-nowrap">
                                        <div class="flex flex-col items-center">
                                            3ª PJ de Defesa dos Direitos da Infância e da Juventude - Atos Infracionais
                                        </div>
                                    </th>
                                    <td class="px-6 py-4">
                                        <h1 class="font-bold text-gray-900 dark:text-gray-200">
                                            Dra. Eliana Mena Cavalcante
                                        </h1>
                                        <p class="text-xs">
                                            (Coordenadora PJ Cíveis-Port. 040/2012)
                                        </p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <h1 class="font-bold text-gray-900 dark:text-gray-200">
                                            Reunião CNMP
                                        </h1>
                                        <p class="text-xs">
                                            04/02/2024 - 06/02/2024
                                        </p>
                                        <p class="text-xs text-red-500">
                                            Designada Dra. Marcela (resp.)
                                        </p>
                                    </td>
                                </tr>
                                <tr class="bg-white hover:bg-gray-50 border">
                                    <th class="px-6 py-4 font-medium whitespace-nowrap">
                                        <div class="flex flex-col items-center">
                                            4ª PJ de Defesa dos Direitos da Infância e da Juventude - Atos Infracionais
                                        </div>
                                    </th>
                                    <td class="px-6 py-4">
                                        <h1 class="font-bold text-gray-900 dark:text-gray-200">
                                            Dra. Eliana Mena Cavalcante
                                        </h1>
                                        <p class="text-xs">
                                            (Coordenadora PJ Cíveis-Port. 040/2012)
                                        </p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <h1 class="font-bold text-gray-900 dark:text-gray-200">
                                            Reunião CNMP
                                        </h1>
                                        <p class="text-xs">
                                            04/02/2024 - 06/02/2024
                                        </p>
                                        <p class="text-xs text-red-500">
                                            Designada Dra. Marcela (resp.)
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
        </CardHeader>
    </Card>
</template>