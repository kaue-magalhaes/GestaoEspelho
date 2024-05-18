<script setup lang="ts">
import {Promotor} from "@/Interfaces/Promotor/Promotor";
import {Promotoria} from "@/Interfaces/Promotoria/Promotoria";
import {GrupoPromotoria} from "@/Interfaces/GrupoPromotoria";

import { ref, onMounted } from 'vue';
import { format } from 'date-fns';
import { v4 as uuidv4 } from 'uuid';

const emit = defineEmits([
    'update:adicionaEvento',
]);

const props = defineProps({
    promotores: {
        type: Array as () => Promotor[] ,
        required: true,
    },
    grupoPromotoria: {
        type: Object as () => GrupoPromotoria,
        required: true,
    },
    promotoria: {
        type: Object as () => Promotoria,
        required: true,
    },
    promotorTitular: {
        type: Object as () => Promotor | undefined,
        required: true,
    },
});

/* Variaveis Reativas */
const tipoEvento = ref<string>('');
const periodoEvento = ref<{ start: Date; end: Date }>({ start: new Date(), end: new Date() });
const tituloEvento = ref<string>('');
const promotor_designado_evento = ref<string>('');

const tipoEventoInvalido = ref<boolean>(false);
const periodoEventoInvalido = ref<boolean>(false);
const periodoEventoAlterado = ref<boolean>(false);
const promotor_designado_eventoInvalido = ref<boolean>(false);
const dialogOpen = ref<boolean>(false);

const eventos = [
  { id: 1, nome: 'Férias', selecionado: false },
  { id: 2, nome: 'Licença', selecionado: false },
  { id: 3, nome: 'Plantão', selecionado: false },
  { id: 4, nome: 'Reunião', selecionado: true },
  { id: 5, nome: 'Outros', selecionado: false },
];

const verificaSeDadosDoEventoSaoValidos = () => {
  tipoEventoInvalido.value = tipoEvento.value === '';
  periodoEventoInvalido.value = periodoEventoAlterado.value === false;
  promotor_designado_eventoInvalido.value = promotor_designado_evento.value === '';

  return !tipoEventoInvalido.value && !periodoEventoInvalido.value && !promotor_designado_eventoInvalido.value;
};

const resetarInformacoes = () => {
    dialogOpen.value = false;
    tipoEvento.value = '';
    periodoEvento.value = { start: new Date(), end: new Date() };
    tituloEvento.value = '';
    promotor_designado_evento.value = '';
    tipoEventoInvalido.value = false;
    periodoEventoInvalido.value = false;
    periodoEventoAlterado.value = false;
    promotor_designado_eventoInvalido.value = false;

};

const updatePeriodo = (periodo: { start: Date; end: Date } | any, alterado: boolean) => {
    periodoEvento.value = { start: periodo.start, end: periodo.end };
    periodoEventoAlterado.value = alterado;
};

const enviaDadosDoEvento = (
    grupoPromotoriaID: string,
    promotoriaID: string,
    evento: {
        titulo: string;
        tipo: string;
        periodo: { start: Date; end: Date };
        promotor_titular_id: string | undefined;
        promotor_designado_id: string
    }
) => {
    if (verificaSeDadosDoEventoSaoValidos()) {
        const novoEvento = {
            uuid: uuidv4(),
            titulo: evento.titulo,
            tipo: evento.tipo,
            periodo_inicio: format(evento.periodo.start, 'yyyy-MM-dd'),
            periodo_fim: format(evento.periodo.end, 'yyyy-MM-dd'),
            promotor_titular_id: evento.promotor_titular_id,
            promotor_designado_id: evento.promotor_designado_id,
        };

        emit('update:adicionaEvento', grupoPromotoriaID, promotoriaID, novoEvento);
        resetarInformacoes();
        dialogOpen.value = false;
    }
};

onMounted(() => {
  //console.log(props.promotores);
});
</script>

<template>
    <Dialog :open="dialogOpen">
        <DialogTrigger as-child>
            <Button variant="ghost" class="w-full mt-2" @click="dialogOpen = true">
                Adicionar Evento
            </Button>
        </DialogTrigger>
        <DialogContent class="w-full max-w-2xl" v-if="props.promotorTitular">
            <DialogHeader>
                <DialogTitle>
                    Adicionar Evento
                </DialogTitle>
                <DialogDescription>
                    Adicione um evento para o Promotor de Justiça {{ props.promotorTitular?.nome }}.
                </DialogDescription>
            </DialogHeader>
            <div class="flex flex-col space-y-4">
                <div class="flex items-center space-x-4">
                    <div class="w-1/2 space-y-1">
                        <Label class="text-base">
                            Tipo do Evento <span class="text-red-500">*</span>
                        </Label>
                        <Select class="mb-2 w-full" v-model="tipoEvento">
                            <SelectTrigger :class="{ 'border-red-500 border-2 text-red-500': tipoEventoInvalido }">
                                <SelectValue placeholder="Selecione o tipo de evento" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectGroup>
                                    <SelectLabel>Eventos</SelectLabel>
                                    <SelectItem v-for="evento in eventos" :key="evento.id" :value="evento.nome">
                                    {{ evento.nome }}
                                    </SelectItem>
                                </SelectGroup>
                            </SelectContent>
                            <span v-if="tipoEventoInvalido" class="text-red-500 text-sm">Selecione o tipo do evento</span>
                        </Select>
                    </div>
                    <div class="w-1/2 space-y-1">
                        <Label class="text-base">
                            Período <span class="text-red-500">*</span>
                        </Label>
                        <DatePicker
                            :range="true"
                            :period_start="periodoEvento.start"
                            :period_end="periodoEvento.end"
                            :is-validation="periodoEventoInvalido"
                            @update:period="updatePeriodo"
                        />
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="w-1/2 space-y-1">
                        <Label class="text-base">
                            Título do Evento
                        </Label>
                        <Input type="text" placeholder="Digite o título do evento" v-model="tituloEvento" />
                    </div>
                    <div class="w-1/2 space-y-1">
                        <Label class="text-base">
                            Promotor designado <span class="text-red-500">*</span>
                        </Label>
                        <Select class="mb-2 w-full" v-model="promotor_designado_evento">
                            <SelectTrigger :class="{ 'border-red-500 border-2 text-red-500': promotor_designado_eventoInvalido }">
                                <SelectValue placeholder="Selecione o Promotor que foi designado" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectGroup>
                                    <SelectLabel>Promotores</SelectLabel>
                                    <SelectItem v-for="promotor in props.promotores" :key="promotor.id" :value="promotor.id">
                                        {{ promotor.nome }}
                                    </SelectItem>
                                </SelectGroup>
                            </SelectContent>
                            <span v-if="promotor_designado_eventoInvalido" class="text-red-500 text-sm">Selecione o Promotor designado</span>
                        </Select>
                    </div>
                </div>
            </div>
            <DialogFooter>
                <Button variant="destructive" @click="resetarInformacoes">
                    Cancelar
                </Button>
                <Button
                    variant="default"
                    @click="enviaDadosDoEvento(
                        props.grupoPromotoria?.id,
                        props.promotoria?.id,
                        {
                            tipo: tipoEvento,
                            periodo: periodoEvento,
                            titulo: tituloEvento,
                            promotor_titular_id: props.promotorTitular.id,
                            promotor_designado_id: promotor_designado_evento
                        }
                    )"
                >
                    Adicionar Evento
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
