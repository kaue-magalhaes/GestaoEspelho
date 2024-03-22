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
    EventoServerSide,
    Evento,
    UrgenciaAtendimentoServeSide,
    UrgenciaAtendimentoClientSide
} from '@/types';
import { Loader2 } from 'lucide-vue-next'

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
        type: Array as () => EventoServerSide[],
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
const atendimentosUrgenciaDados = ref<UrgenciaAtendimentoClientSide[]>([]);
const listaAtribuicoes = ref<Atribuicoes[]>([]);
const listaEventos = ref<Evento[]>([]);
const salvo = ref(false);
const exibirBotaoSalvar = ref(false);
const exibirBotaoPublicar = ref(false);
const carregandoSalvamento = ref(false);
const carregandoPublicacao = ref(false);

const updatePeriodoEspelho = (value: string[]) => {
    periodoEspelho.value = value;
    exibirBotaoSalvar.value = true;
    exibirBotaoPublicar.value = true;
};

const updateGrupoDeTodasAsPromotorias = (value: GrupoPromotoria[]) => {
    grupoDeTodasAsPromotoriasDados.value = value;
    if (value.length === 0) {
        grupoDeTodasAsPromotoriasDados.value = [];
    }
    exibirBotaoSalvar.value = true;
    exibirBotaoPublicar.value = true;
}

const updateAtribuicao = (value: Atribuicoes[]) => {
    listaAtribuicoes.value = value;
};

const updateAtendimentosUrgencia = (value: []) => {
    atendimentosUrgenciaDados.value = value;
    exibirBotaoSalvar.value = true;
    exibirBotaoPublicar.value = true;
};

const updateListaEventos = (value: Evento[]) => {
    listaEventos.value = value;
    exibirBotaoSalvar.value = true;
    exibirBotaoPublicar.value = true;
};

function stringToDate(dateString: string) {
    const [year, month, day] = dateString.split('-').map(Number);
    return new Date(year, month - 1, day);
}

const salvarEspelho = async () => {
    carregandoSalvamento.value = true;
    const data = {
        periodoEspelho: periodoEspelho.value,
        listaEventos: listaEventos.value,
        atendimentosUrgenciaDados: atendimentosUrgenciaDados.value,
    };

    try {
        const response = await axios.put(`/espelho${props.espelho.id}`, data);
        exibirBotaoSalvar.value = false;
        carregandoSalvamento.value = false;
        salvo.value = true;

    } catch (error) {
        console.error(error);
    }
};

const publicarEspelho = async () => {
    carregandoPublicacao.value = true;
    const data = {
        periodoEspelho: periodoEspelho.value,
        listaEventos: listaEventos.value,
        atendimentosUrgenciaDados: atendimentosUrgenciaDados.value,
    };

    try {
        const response = await axios.put(`/espelho/publicar/${props.espelho.id}`, data);
        exibirBotaoPublicar.value = false;
    } catch (error) {
        console.error(error);
    }
};

const processaEventos = (eventos: EventoServerSide[]) => {
    return eventos.map(evento => ({
        uuid: evento.id,
        titulo: evento.titulo,
        tipo: evento.tipo,
        periodo_inicio: evento.periodo_inicio,
        periodo_fim: evento.periodo_fim,
        promotor_titular_id: evento.promotor_titular_id,
        promotor_designado_id: evento.promotor_designado_id,
    }));
};

const processaUrgenciaAtendimentos = (urgenciaAtendimentos: UrgenciaAtendimentoServeSide[]) => {
    return urgenciaAtendimentos.map(atendimentoUrgencia => ({
        uuid: atendimentoUrgencia.id,
        periodo_inicio: atendimentoUrgencia.periodo_inicio,
        periodo_fim: atendimentoUrgencia.periodo_fim,
        promotor_designado_id: atendimentoUrgencia.promotor_designado_id,
    }));    
};

onBeforeMount(() => {
    eventosComUUID.value = processaEventos(props.eventos);
    listaEventos.value = eventosComUUID.value;

    atendimentosUrgenciaDados.value = processaUrgenciaAtendimentos(props.urgenciaAtendimentos);
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
    <span class="fixed bottom-5 right-5 z-50 space-x-2">
        <span v-if="exibirBotaoSalvar">
            <Button v-if="!carregandoSalvamento" variant="outline" @click="salvarEspelho">
                Salvar as alterações
            </Button>
            <Button v-else variant="outline" disabled>
                <Loader2 class="w-4 h-4 mr-2 animate-spin" />
                Enviando
            </Button>
        </span>
        <span v-if="exibirBotaoPublicar && salvo">
            <AlertDialog>
                <AlertDialogTrigger>
                    <Button variant="default">
                        Publicar Espelho
                    </Button>
                </AlertDialogTrigger>
                <AlertDialogContent>
                    <AlertDialogHeader>
                        <AlertDialogTitle>
                            Publicar Espelho
                        </AlertDialogTitle>
                        <AlertDialogDescription>
                            Você tem certeza que deseja publicar o espelho?
                        </AlertDialogDescription>
                    </AlertDialogHeader>
                    <AlertDialogFooter>
                        <AlertDialogCancel class="bg-red-500 hover:bg-red-400 text-white hover:text-white">
                            Cancelar
                        </AlertDialogCancel>
                        <Button v-if="!carregandoPublicacao" variant="default" @click="publicarEspelho">
                            Publicar Espelho
                        </Button>
                        <Button v-else variant="default" disabled>
                            <Loader2 class="w-4 h-4 mr-2 animate-spin" />
                            Publicando
                        </Button>
                    </AlertDialogFooter>
                </AlertDialogContent>
            </AlertDialog>
        </span>
    </span>
</template>
