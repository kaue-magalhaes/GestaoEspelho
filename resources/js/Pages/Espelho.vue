<script setup lang="ts">
import { Promotor, Promotoria } from '@/types';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, onMounted } from 'vue';
import { Head } from '@inertiajs/vue3';
import { Carousel, CarouselContent, CarouselItem, CarouselNext, CarouselPrevious } from '@/Components/ui/carousel';
import Preview from '@/Components/EspelhoComponents/Preview.vue';
import Editor from '@/Components/EspelhoComponents/Editor.vue';

type Municipios = {
  nome: string;
  promotorias: {
    nome: string;
    nomePromotor: string;
    eventos: {
      tipo: string;
      periodo: string[];
      titulo: string;
      promotorDesignado: string;
    }[];
  }[];
};

const props = defineProps({
    promotorias: {
        type: Object as () => { all: Promotoria[] },
        required: true,
    },
    promotores: {
        type: Array as () => Promotor[],
        required: true,
    },
});

const periodoEspelho = ref<string[]>([]);
const municipiosDados = ref<Municipios[]>([]);
const atendimentosUrgenciaMacapa = ref<any[]>([]);
const promotoriasUpdate = ref<Promotoria[]>([]);
const listaPromotoresSubstitutosAtribuicoes = ref<{ promotor: Promotor; atribuicao: Array<string> }[]>([]);

const updatePromotorias = (value: { all: Promotoria[] }) => {
    promotoriasUpdate.value = value.all;
};

const updatePeriodoEspelho = (value: string[]) => {
    periodoEspelho.value = value;
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

const deleteEventoInterior = (promotoria_id: number) => {
    //const index = promotoriasInteriorEventos.value.findIndex((evento) => evento.promotoria.id === promotoria_id);
    //promotoriasInteriorEventos.value.splice(index, 1);
};

const updateMunicipiosDados = (value: Municipios[]) => {
    municipiosDados.value = value;
}
const adicionaNovaAtribuicao = (value: { promotor: Promotor; atribuicao: Array<string> }) => {
    listaPromotoresSubstitutosAtribuicoes.value.push(value);
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
                                :promotores="promotores"
                                @update:periodoEspelho="updatePeriodoEspelho"
                                @update:municipiosDados="updateMunicipiosDados"
                                @update:novaAtribuicao="adicionaNovaAtribuicao"
                                @delete:deleteEventoInterior="deleteEventoInterior"
                            />
                        </CarouselItem>
                        <CarouselItem>
                            <Preview
                                :promotorias="promotorias.all"
                                :periodoEspelho="periodoEspelho"
                                :municipiosDados="municipiosDados"
                                :listaPromotoresSubstitutosAtribuicoes="listaPromotoresSubstitutosAtribuicoes"
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
