<script setup lang="ts">
import { ref, onBeforeMount } from 'vue';
import { Head } from '@inertiajs/vue3';
import { format } from 'date-fns';
import axios from 'axios';
import {
    GrupoPromotoria,
    Atribuicoes,
    Espelho,
    Promotor,
    Evento,
    UrgenciaAtendimentoServeSide
} from '@/types';
import { Carousel, CarouselContent, CarouselItem, CarouselNext, CarouselPrevious } from '@/Components/ui/carousel';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Preview from '@/Components/EspelhoComponents/Preview.vue';
import Editor from '@/Components/EspelhoComponents/Editor.vue';
import Button from '@/Components/ui/button/Button.vue';

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
        type: Array as () => { id : string, titulo: string, tipo: string, periodo_inicio: string, periodo_fim: string, promotor_titular_id: string, promotor_designado_id: string }[],
        required: true,
    },
    urgenciaAtendimentos: {
        type: Array as () => UrgenciaAtendimentoServeSide[],
        required: true,
    },
});
const eventosComUUID = ref<Evento[]>([]);

const periodoEspelho = ref<string[]>([
    format(stringToDate(props.espelho?.periodo_inicio), 'dd/MM/yyyy'),
    format(stringToDate(props.espelho?.periodo_fim), 'dd/MM/yyyy'),
]);
const grupoDeTodasAsPromotoriasDados = ref<GrupoPromotoria[]>([]);
const atendimentosUrgenciaDados = ref([]);
const listaAtribuicoes = ref<Atribuicoes[]>([]);
const listaEventos = ref<Evento[]>([]);

const updatePeriodoEspelho = (value: string[]) => {
    periodoEspelho.value = value;
};

const updateGrupoDeTodasAsPromotorias = (value: GrupoPromotoria[]) => {
    grupoDeTodasAsPromotoriasDados.value = value;
    if (value.length === 0) {
        grupoDeTodasAsPromotoriasDados.value = [];
    }
}

const updateAtribuicao = (value: Atribuicoes[]) => {
    listaAtribuicoes.value = value;
};

const updateAtendimentosUrgencia = (value: []) => {
    atendimentosUrgenciaDados.value = value;
};

const updateListaEventos = (value: Evento[]) => {
    listaEventos.value = value;
};

function stringToDate(dateString: string) {
    const [year, month, day] = dateString.split('-').map(Number);
    return new Date(year, month - 1, day);
}

const salvarEspelho = async () => {
    const data = {
        periodoEspelho: periodoEspelho.value,
        listaEventos: listaEventos.value,
        atendimentosUrgenciaDados: atendimentosUrgenciaDados.value,
    };

    try {
        const response = await axios.put(`/espelho${props.espelho.id}`, data);
        console.log(response.data);
    } catch (error) {
        console.error(error);
    }
};

onBeforeMount(() => {
    eventosComUUID.value = props.eventos.map(evento => ({
        uuid: evento.id,
        titulo: evento.titulo,
        tipo: evento.tipo,
        periodo_inicio: evento.periodo_inicio,
        periodo_fim: evento.periodo_fim,
        promotor_titular_id: evento.promotor_titular_id,
        promotor_designado_id: evento.promotor_designado_id,
    }));
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
                                :eventos="eventosComUUID"
                                :urgenciaAtendimentos="props.urgenciaAtendimentos"
                                @update:periodoEspelho="updatePeriodoEspelho"
                                @update:grupoDeTodasAsPromotorias="updateGrupoDeTodasAsPromotorias"
                                @update:dadosDosAtendimentosUrgencia="updateAtendimentosUrgencia"
                                @update:atribuicao="updateAtribuicao"
                                @update:ListaEventos="updateListaEventos"
                            />
                        </CarouselItem>
                        <CarouselItem>
                            <Preview
                                :periodoEspelho="periodoEspelho"
                                :grupoPromotoriaDeTodasAsPromotorias="grupoDeTodasAsPromotoriasDados"
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
    <Button variant="default" class="fixed bottom-5 right-5 z-50" @click="salvarEspelho">
        Salvar as alterações
    </Button>
</template>
