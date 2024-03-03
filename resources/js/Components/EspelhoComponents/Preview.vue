<script setup lang="ts">
import { Promotor, Promotoria, GrupoPromotoria, Atribuicoes } from '@/types';
import { ref, computed, watchEffect } from 'vue';
import { Card, CardContent, CardHeader } from '@/Components/ui/card';

import EntranciaFinalSantanaPreview from '@/Components/EspelhoComponents/PreviewComponents/EntranciaFinalSantanaPreview.vue';
import EntranciaInicialPreview from '@/Components/EspelhoComponents/PreviewComponents/EntranciaInicialPreview.vue'
import TabelaPromotoresSubstitutosPreview from '@/Components/EspelhoComponents/PreviewComponents/TabelaPromotoresSubstitutosPreview.vue';

const props = defineProps({
    periodoEspelho: {
        type: Array as () => string[],
        required: true,
    },
    promotoriasDados: {
        type: Array as () => GrupoPromotoria[],
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

const municipiosInterior = ref<GrupoPromotoria[]>([]);
const promotoriasSantana = ref<GrupoPromotoria[]>([]);


watchEffect(() => {
    props.promotoriasDados.forEach((grupoPromotoria) => {
        grupoPromotoria.promotorias.forEach((promotoria) => {
            if (promotoria.municipio === 'Macapá') {
                console.log('Macapá');
                //promotoriasMacapa.value.push(grupoPromotoria);
            } else if (promotoria.municipio === 'Santana') {
                promotoriasSantana.value.push(grupoPromotoria);
            } else {
                if (municipiosInterior.value.length === 0) {
                    municipiosInterior.value.push(grupoPromotoria);
                } else {
                    const index = municipiosInterior.value.findIndex((municipio) => municipio.nome === grupoPromotoria.nome);
                    if (index === -1) {
                        municipiosInterior.value.push(grupoPromotoria);
                    }
                }
            }
        });
    });
    
    if (props.promotoriasDados.length === 0) {
        promotoriasSantana.value = [];
        municipiosInterior.value = [];
    }
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
            <!-- <EntranciaFinalMacapaPreview /> -->

            <EntranciaFinalSantanaPreview 
                v-if="promotoriasSantana.length > 0"
                :promotorias="promotoriasSantana"
            /> 
            <EntranciaInicialPreview
                v-if="municipiosInterior.length > 0"
                :promotoriasDados="municipiosInterior"
            />
            <TabelaPromotoresSubstitutosPreview
                :listaAtribuicoes="listaAtribuicoes"
            />
        </CardContent>
    </Card>
</template>