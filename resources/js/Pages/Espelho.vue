<script setup lang="ts">
import { Promotoria, GrupoPromotoria, Atribuicoes } from '@/types';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, onMounted } from 'vue';
import { Head } from '@inertiajs/vue3';
import { Carousel, CarouselContent, CarouselItem, CarouselNext, CarouselPrevious } from '@/Components/ui/carousel';
import Preview from '@/Components/EspelhoComponents/Preview.vue';
import Editor from '@/Components/EspelhoComponents/Editor.vue';

const props = defineProps({
    promotorias: {
        type: Object as () => { all: Promotoria[] },
        required: true,
    },
});

const periodoEspelho = ref<string[]>([]);
const promotoriasDados = ref<GrupoPromotoria[]>([]);
const atendimentosUrgenciaMacapa = ref<any[]>([]);
const promotoriasUpdate = ref<Promotoria[]>([]);
const listaAtribuicoes = ref<Atribuicoes[]>([]);

const updatePromotorias = (value: { all: Promotoria[] }) => {
    promotoriasUpdate.value = value.all;
};

const updatePeriodoEspelho = (value: string[] | string) => {
    if (Array.isArray(value)) {
        periodoEspelho.value = value;
    } else {
        periodoEspelho.value.push(value);
    }
};

const updatePromotorUrgencia = (index: number, value: string) => {
    if (!atendimentosUrgenciaMacapa.value[index]) {
        atendimentosUrgenciaMacapa.value[index] = {};
    }
    atendimentosUrgenciaMacapa.value[index].promotor = value;
};

const updatePeriodoUrgencia = (index: number, value: string) => {
    if (!atendimentosUrgenciaMacapa.value[index]) {
        atendimentosUrgenciaMacapa.value[index] = {};
    }
    atendimentosUrgenciaMacapa.value[index].periodo = value;
};

const removePromotorUrgenciaItem = (index: number) => {
    atendimentosUrgenciaMacapa.value.splice(index, 1);
};

const updatePromotoriasDados = (value: GrupoPromotoria[]) => {
    //console.log(value);
    promotoriasDados.value = value;
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

onMounted(() => {
    //console.log(props.promotorias);
    //console.log(promotoriasInteriorEventos.value);
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
                                :promotorias="promotorias.all"
                                @update:periodoEspelho="updatePeriodoEspelho"
                                @update:promotoriasDados="updatePromotoriasDados"
                            />
                        </CarouselItem>
                        <CarouselItem>
                            <Preview
                                :periodoEspelho="periodoEspelho"
                                :promotoriasDados="promotoriasDados"
                                :listaAtribuicoes="listaAtribuicoes"
                                :atendimentos-urgencia-macapa="atendimentosUrgenciaMacapa"
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
