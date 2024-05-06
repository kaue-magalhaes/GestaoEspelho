<script setup lang="ts">
import {UrgenciaAtendimento} from "@/Interfaces/UrgenciaAtendimento";
import {Promotor} from "@/Interfaces/Promotor";
import {Espelho} from "@/Interfaces/Espelho/Espelho";
import {Evento} from "@/Interfaces/Evento";
import {GrupoPromotoria} from "@/Interfaces/GrupoPromotoria";
import {Atribuicoes} from "@/Interfaces/Atribuicoes";

import {onBeforeMount, ref} from 'vue';
import {Head} from '@inertiajs/vue3';
import {format} from 'date-fns';
import axios from 'axios';
import {toast} from 'vue-sonner';
import {Loader2} from 'lucide-vue-next'
import {Promotoria} from "@/Interfaces/Promotoria/Promotoria";

const props = defineProps({
    espelho: {
        type: Object as () => Espelho,
        required: true,
    },
    grupoPromotorias: {
        type: Array as () => GrupoPromotoria[],
        required: true,
    },
    promotorias: {
        type: Array as () => Promotoria[],
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
const eventosComUUID = ref<Evento[]>([]);

const periodoEspelho = ref<string[]>([
    format(stringToDate(props.espelho?.periodo_inicio), 'dd/MM/yyyy'),
    format(stringToDate(props.espelho?.periodo_fim), 'dd/MM/yyyy'),
]);
const grupoDeTodasAsPromotoriasDados = ref<GrupoPromotoria[]>(props.grupoPromotorias);
const atendimentosUrgenciaDados = ref<UrgenciaAtendimento[]>([]);
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
        await axios.put(`/espelho/${props.espelho.id}`, data);
        exibirBotaoSalvar.value = false;
        carregandoSalvamento.value = false;
        salvo.value = true;

        toast.success('Alteração foi salva com sucesso!');

    } catch (error) {
        console.error(error);
    }
}

const publicarEspelho = async () => {
    carregandoPublicacao.value = true;
    const data = {
        periodoEspelho: periodoEspelho.value,
        listaEventos: listaEventos.value,
        atendimentosUrgenciaDados: atendimentosUrgenciaDados.value,
    };

    try {
        await axios.post(`/espelho/publicar/${props.espelho.id}`, data);
        exibirBotaoPublicar.value = false;
        carregandoPublicacao.value = false;
        salvo.value = false;

        toast.success('Espelho publicado foi publicado com sucesso!');
    } catch (error) {
        console.error(error);
    }
}

const processaEventos = (eventos: Evento[]) => {
    return eventos.map(evento => ({
        id: evento.id,
        uuid: evento.uuid,
        titulo: evento.titulo ? evento.titulo : '',
        tipo: evento.tipo,
        periodo_inicio: evento.periodo_inicio,
        periodo_fim: evento.periodo_fim,
        promotor_titular_id: evento.promotor_titular_id,
        promotor_designado_id: evento.promotor_designado_id,
    }));
};

const processaUrgenciaAtendimentos = (urgenciaAtendimentos: UrgenciaAtendimento[]) => {
    return urgenciaAtendimentos.map(atendimentoUrgencia => ({
        id: atendimentoUrgencia.id,
        periodo_inicio: atendimentoUrgencia.periodo_inicio,
        periodo_fim: atendimentoUrgencia.periodo_fim,
        promotor_designado_id: atendimentoUrgencia.promotor_designado_id,
        created_at: atendimentoUrgencia.created_at,
        updated_at: atendimentoUrgencia.updated_at,
    }));
};

onBeforeMount(() => {
    eventosComUUID.value = processaEventos(props.eventos);
    listaEventos.value = eventosComUUID.value;

    atendimentosUrgenciaDados.value = processaUrgenciaAtendimentos(props.urgenciaAtendimentos);
});
</script>

<template>
    <Head title="Espelho"/>
    <AuthenticatedLayout>
        <ContainerComponent>
            <Carousel class="focus-visible:outline-none">
                <CarouselContent>
                    <CarouselItem>
                        <Editor
                            :espelho="espelho"
                            :promotores="props.promotores"
                            :grupoPromotorias="props.grupoPromotorias"
                            :promotorias="props.promotorias"
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
                <CarouselPrevious/>
                <CarouselNext/>
            </Carousel>
        </ContainerComponent>
    </AuthenticatedLayout>
    <span class="fixed bottom-5 right-5 z-50 space-x-2">
        <span v-if="exibirBotaoSalvar">
            <Button v-if="!carregandoSalvamento" variant="outline" @click="salvarEspelho">
                Salvar as alterações
            </Button>
            <Button v-else variant="outline" disabled>
                <Loader2 class="w-4 h-4 mr-2 animate-spin"/>
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
                            <Loader2 class="w-4 h-4 mr-2 animate-spin"/>
                            Publicando
                        </Button>
                    </AlertDialogFooter>
                </AlertDialogContent>
            </AlertDialog>
        </span>
    </span>
</template>
