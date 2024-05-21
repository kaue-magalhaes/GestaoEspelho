<script setup lang="ts">
import {UrgenciaAtendimento} from "@/Interfaces/UrgenciaAtendimento/UrgenciaAtendimento";
import {Promotores} from "@/Interfaces/Promotor/Promotores";
import {Espelho} from "@/Interfaces/Espelho/Espelho";
import {Evento} from "@/Interfaces/Evento/Evento";
import {GrupoPromotoria} from "@/Interfaces/GrupoPromotoria/GrupoPromotoria";
import {Atribuicoes} from "@/Interfaces/Atribuicoes";

import EditorComponent from "@/Components/EspelhoComponents/EditorComponent.vue";
import PreviewComponent from "@/Components/EspelhoComponents/PreviewComponent.vue";
import {onBeforeMount, ref} from 'vue';
import axios from 'axios';
import {toast} from 'vue-sonner';
import {Loader2} from 'lucide-vue-next'
import EditorLayout from "@/Layouts/EditorLayout.vue";
import {Eventos} from "@/Interfaces/Evento/Eventos";
import {UrgenciaAtendimentos} from "@/Interfaces/UrgenciaAtendimento/UrgenciaAtendimentos";
import {GrupoPromotorias} from "@/Interfaces/GrupoPromotoria/GrupoPromotorias";
import {Promotorias} from "@/Interfaces/Promotoria/Promotorias";
import {useUrgenciaAtendimentosStore} from "@/stores/urgenciaAtendimentoStore";
import {useEspelhoStore} from "@/stores/espelhoStore";
import {storeToRefs} from "pinia";
import {useUpdateDataStore} from "@/stores/updateDataStore";

const espelhoStore = useEspelhoStore();
const { getEspelhos } = espelhoStore;

const urgenciaAtendimentosStore = useUrgenciaAtendimentosStore();
const { getUrgenciaAtendimentos } = urgenciaAtendimentosStore;

const updateDataStore = useUpdateDataStore();
const { existsChanges, loading } = storeToRefs(updateDataStore);
const { saveChanges } = updateDataStore;

const props = defineProps({
    espelho: {
        type: Object as () => Espelho,
        required: true,
    },
    grupoPromotorias: {
        type: Object as () => GrupoPromotorias,
        required: true,
    },
    promotorias: {
        type: Object as () => Promotorias,
        required: true,
    },
    promotores: {
        type: Object as () => Promotores,
        required: true,
    },
    eventos: {
        type: Object as () => Eventos,
        required: true,
    }
});
const eventosComUUID = ref<Evento[]>([]);

const grupoDeTodasAsPromotoriasDados = ref<GrupoPromotoria[]>(props.grupoPromotorias?.data);
const atendimentosUrgenciaDados = ref<UrgenciaAtendimento[]>([]);
const listaAtribuicoes = ref<Atribuicoes[]>([]);
const listaEventos = ref<Evento[]>([]);
const salvo = ref(false);
const exibirBotaoSalvar = ref(false);
const exibirBotaoPublicar = ref(false);
const carregandoPublicacao = ref(false);

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

const publicarEspelho = async () => {
    carregandoPublicacao.value = true;
    const data = {
        /*periodoEspelho: periodoEspelho.value,*/
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

onBeforeMount(() => {
    getEspelhos()
    getUrgenciaAtendimentos();

    eventosComUUID.value = processaEventos(props.eventos?.data);
    listaEventos.value = eventosComUUID.value;
});
</script>

<template>
    <EditorLayout>
        <template v-slot:editor>
            <EditorComponent
                :promotores="props.promotores?.data"
                :grupoPromotorias="props.grupoPromotorias?.data"
                :promotorias="props.promotorias?.data"
                :eventos="eventosComUUID"
                @update:grupoDeTodasAsPromotorias="updateGrupoDeTodasAsPromotorias"
                @update:dadosDosAtendimentosUrgencia="updateAtendimentosUrgencia"
                @update:atribuicao="updateAtribuicao"
                @update:ListaEventos="updateListaEventos"
            />
        </template>
        <template v-slot:preview>
            <PreviewComponent
                :promotores="props.promotores?.data"
                :grupoPromotoriaDeTodasAsPromotorias="grupoDeTodasAsPromotoriasDados"
                :listaAtribuicoes="listaAtribuicoes"
            />
        </template>
    </EditorLayout>
<!--  Actions Buttons  -->
    <span class="fixed bottom-5 right-5 z-50 space-x-2">
        <span v-if="existsChanges">
            <Button v-if="loading" variant="outline" disabled>
                <Loader2 class="w-4 h-4 mr-2 animate-spin"/>
                Enviando
            </Button>
            <Button v-else variant="outline" @click="saveChanges(props.espelho.id)">
                Salvar as alterações
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
