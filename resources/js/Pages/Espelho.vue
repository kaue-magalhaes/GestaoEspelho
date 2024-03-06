<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { Head } from '@inertiajs/vue3';
import { format } from 'date-fns';
import {
    GrupoPromotoria,
    Atribuicoes,
    AtendimentoUrgencia,
    Espelho,
    Promotor,
    Evento,
    UrgenciaAtendimento
} from '@/types';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Preview from '@/Components/EspelhoComponents/Preview.vue';
import Editor from '@/Components/EspelhoComponents/Editor.vue';
import { Carousel, CarouselContent, CarouselItem, CarouselNext, CarouselPrevious } from '@/Components/ui/carousel';

const props = defineProps({
    espelho: {
        type: Object as () => Espelho,
        required: true,
    },
    promotores: {
        type: Array as () => Promotor[],
        required: true,
    },
    eventos: {
        type: Array as () => Evento[],
        required: true,
    },
    urgenciaAtendimentos: {
        type: Array as () => UrgenciaAtendimento[],
        required: true,
    },
});

const periodoEspelho = ref<string[]>([
    format(new Date(props.espelho?.periodo_inicio), 'dd/MM/yyyy'),
    format(new Date(props.espelho?.periodo_fim), 'dd/MM/yyyy'),
]);
const promotoriasDados = ref<GrupoPromotoria[]>([]);
const atendimentosUrgenciaDados = ref<AtendimentoUrgencia[]>([]);
const listaAtribuicoes = ref<Atribuicoes[]>([]);

const updatePeriodoEspelho = (value: string[] | string) => {
    if (Array.isArray(value)) {
        periodoEspelho.value = value;
    } else {
        periodoEspelho.value.push(value);
    }
};

const updatePromotoriasDados = (value: GrupoPromotoria[]) => {
    //console.log(value);
    promotoriasDados.value = value;
    if (value.length === 0) {
        promotoriasDados.value = [];
    }
    listaAtribuicoes.value = [];
    updateNovaAtribuicao(promotoriasDados.value);
    //console.log(listaAtribuicoes.value);

}

const updateNovaAtribuicao = (value: GrupoPromotoria[] ) => {
    value.forEach((municipio) => {
        municipio.promotorias.forEach((promotoria) => {
            promotoria.eventos.forEach((evento) => {
                if (listaAtribuicoes.value.length === 0) {
                    listaAtribuicoes.value.push({
                        id: listaAtribuicoes.value.length,
                        nome_promotor: evento.promotor_designado_evento,
                        atribuicoes: [
                            {
                                id: evento.id,
                                tipo: evento.tipo,
                                periodo: evento.periodo,
                                titulo: evento.titulo,
                                promotor_designado_evento: evento.promotor_designado_evento,
                            },
                        ],
                    });
                } else {
                    const index = listaAtribuicoes.value.findIndex((atribuicao) => atribuicao.nome_promotor === evento.promotor_designado_evento);
                    if (index === -1) {
                        listaAtribuicoes.value.push({
                            id: listaAtribuicoes.value.length,
                            nome_promotor: evento.promotor_designado_evento,
                            atribuicoes: [
                                {
                                    id: evento.id,
                                    tipo: evento.tipo,
                                    periodo: evento.periodo,
                                    titulo: evento.titulo,
                                    promotor_designado_evento: evento.promotor_designado_evento,
                                },
                            ],
                        });
                    } else {
                        listaAtribuicoes.value[index].atribuicoes.push({
                            id: evento.id,
                            tipo: evento.tipo,
                            periodo: evento.periodo,
                            titulo: evento.titulo,
                            promotor_designado_evento: evento.promotor_designado_evento,
                        });
                    }
                }
            });
        });
    });

};

const updateAtendimentosUrgencia = (value: AtendimentoUrgencia[]) => {
  //console.log(value);
  atendimentosUrgenciaDados.value = value;
};

onMounted(() => {
    // console.log(props.espelho);
    // console.log(props.promotores);
    // console.log(props.eventos);
    // console.log(props.urgenciaAtendimentos);
});
</script>

<template>
    <Head title="Espelho" />
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Carousel class="focus-visible:outline-none">
                    <CarouselContent>
                        <CarouselItem>
                            <Editor
                                :espelho="espelho"
                                :promotorias="espelho.promotorias"
                                :promotores="props.promotores"
                                :eventos="props.eventos"
                                :urgenciaAtendimentos="props.urgenciaAtendimentos"
                                @update:periodoEspelho="updatePeriodoEspelho"
                                @update:promotoriasDados="updatePromotoriasDados"
                                @update:atendimentosUrgenciaDados="updateAtendimentosUrgencia"
                            />
                        </CarouselItem>
                        <CarouselItem>
                            <Preview
                                :periodoEspelho="periodoEspelho"
                                :promotoriasDados="promotoriasDados"
                                :listaAtribuicoes="listaAtribuicoes"
                                :atendimentosUrgenciaDados="atendimentosUrgenciaDados"
                            />
                        </CarouselItem>
                    </CarouselContent>
                    <CarouselPrevious />
                    <CarouselNext />
                </Carousel>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
