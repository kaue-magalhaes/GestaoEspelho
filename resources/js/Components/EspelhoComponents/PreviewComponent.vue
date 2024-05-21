<script setup lang="ts">
import {GrupoPromotoria} from "@/Interfaces/GrupoPromotoria/GrupoPromotoria";
import {Atribuicoes} from "@/Interfaces/Atribuicoes";
import {UrgenciaAtendimento} from "@/Interfaces/UrgenciaAtendimento/UrgenciaAtendimento";

import {ref, watchEffect} from 'vue';
import {Promotor} from "@/Interfaces/Promotor/Promotor";
import {storeToRefs} from "pinia";
import {useEspelhoStore} from "@/stores/espelhoStore";
import {format} from "date-fns";

const store = useEspelhoStore();
const {espelho, loading} = storeToRefs(store);

const props = defineProps({
    promotores: {
        type: Array as () => Promotor[],
        required: true,
    },
    grupoPromotoriaDeTodasAsPromotorias: {
        type: Array as () => GrupoPromotoria[],
        required: true,
    },
    listaAtribuicoes: {
        type: Array as () => Atribuicoes[],
        required: true,
    },
    atendimentosUrgenciaDados: {
        type: Array as () => UrgenciaAtendimento[],
        required: true,
    },
});

const promotoriasMacapa = ref<GrupoPromotoria[]>([]);
const promotoriasSantana = ref<GrupoPromotoria[]>([]);
const promotoriasInterior = ref<GrupoPromotoria[]>([]);

watchEffect(() => {
    const municipios: Record<string, GrupoPromotoria[]> = {
        'Macapa': [],
        'Santana': [],
        'Interior': []
    };

    if (props.grupoPromotoriaDeTodasAsPromotorias.length === 0) {
        promotoriasMacapa.value = [];
        promotoriasSantana.value = [];
        promotoriasInterior.value = [];
        return;
    }
    props.grupoPromotoriaDeTodasAsPromotorias.forEach((grupoPromotoria) => {
        const municipioNome = grupoPromotoria?.municipio?.nome;
        if (municipioNome === 'Macapá') {
            municipios['Macapa'].push(grupoPromotoria);
        } else if (municipioNome === 'Santana') {
            municipios['Santana'].push(grupoPromotoria);
        } else {
            if (municipios['Interior'].findIndex((grupo) => grupo.nome === grupoPromotoria.nome) === -1) {
                municipios['Interior'].push(grupoPromotoria);
            }
        }
    });

    promotoriasMacapa.value = municipios['Macapa'];
    promotoriasSantana.value = municipios['Santana'];
    promotoriasInterior.value = municipios['Interior'];
});
</script>

<template>
    <div v-if="loading" class="w-full flex justify-center items-center">
        Carregando...
    </div>
    <Card v-else>
        <CardHeader>
            <div class="w-full flex justify-center items-center">
                <div class="w-full flex flex-col items-center space-y-16">
                    <div class="flex flex-col items-center">
                        <a href="https://www.mpap.mp.br" target="_blank" class="flex flex-col items-center">
                            <div class="h-16 w-auto sm:h-20">
                                <img alt="MPAP Logo"
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
                        <div v-if="espelho" class="text-sm text-gray-500 dark:text-gray-400">
                            <span v-if="espelho.periodo_inicio === espelho.periodo_fim">
                                Espelho de {{ format(espelho.periodo_inicio, 'dd/MM/yyyy') }}
                            </span>
                            <span v-else>
                                Espelho de {{
                                    format(espelho.periodo_inicio, 'dd/MM/yyyy')
                                }} a {{ format(espelho.periodo_fim, 'dd/MM/yyyy') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </CardHeader>
        <CardContent class="flex flex-col items-center space-y-8 w-full">
            <!--            <EntranciaFinalMacapaPreview
                            v-if="promotoriasMacapa.length > 0 || props.atendimentosUrgenciaDados.length > 0"
                            :promotores="props.promotores"
                            :grupoPromotorias="promotoriasMacapa"
                            :urgenciaAtendimentos="props.atendimentosUrgenciaDados"
                        />-->
            <!--            <EntranciaFinalSantanaPreview-->
            <!--                v-if="promotoriasSantana.length > 0"-->
            <!--                :grupoPromotorias="promotoriasSantana"-->
            <!--            />-->
            <!--            <EntranciaInicialPreview-->
            <!--                v-if="promotoriasInterior.length > 0"-->
            <!--                :promotoriasDados="promotoriasInterior"-->
            <!--            />-->
            <!--            <TabelaPromotoresSubstitutosPreview-->
            <!--                :listaAtribuicoes="listaAtribuicoes"-->
            <!--            />-->
        </CardContent>
    </Card>
</template>
