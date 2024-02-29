<script setup lang="ts">
import { computed, onMounted } from 'vue';
import { Promotor, Promotoria } from '@/types';
import { Card, CardContent, CardHeader } from '@/Components/ui/card';

import EntranciaInicialPreview from '@/Components/EspelhoComponents/PreviewComponents/EntranciaInicialPreview.vue'
import TabelaPromotoresSubstitutosPreview from '@/Components/EspelhoComponents/PreviewComponents/TabelaPromotoresSubstitutosPreview.vue';

type Atribuicoes = {
    id: number;
    nomePromotor: string;
    atribuicoes: {
        id: number;
        tipo: string;
        periodo: string[];
        titulo: string;
        promotorDesignadoEvento: string;
    }[]
};

type Municipios = {
  nome: string;
  promotorias: {
    nome: string;
    nomePromotor: string;
    eventos: {
      id: number;
      tipo: string;
      periodo: string[];
      titulo: string;
      promotorDesignadoEvento: string;
    }[];
  }[];
};

const props = defineProps({
    promotorias: {
        type: Array as () => Promotoria[],
        required: true,
    },
    periodoEspelho: {
        type: Array as () => string[],
        required: true,
    },
    municipiosDados: {
        type: Array as () => Municipios[],
        required: true,
    },
    listaAtribuicoes: {
        type: Array as () => Atribuicoes[],
        required: true,
    },
    atendimentosUrgenciaMacapa: {
        type: Array as () => any[],
        required: true,
    },
});

onMounted(() => {
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
                        <div v-if="periodoEspelho.length > 0" class="text-sm text-gray-500 dark:text-gray-400">
                            <span v-if="periodoEspelho[0] !== undefined && periodoEspelho[1] !== undefined">
                                Espelho de {{ periodoEspelho[0] }} a {{ periodoEspelho[1] }}
                            </span>
                            <span v-else>
                                Espelho do dia {{ periodoEspelho[0] }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </CardHeader>
        <CardContent class="flex flex-col items-center space-y-8 w-full">
            <!-- <EntranciaFinalMacapaPreview />
            <EntranciaFinalSantanaPreview /> -->
            <EntranciaInicialPreview
                :municipiosDados="municipiosDados"
            />
            <TabelaPromotoresSubstitutosPreview
                :listaAtribuicoes="listaAtribuicoes"
            />
        </CardContent>
    </Card>
</template>