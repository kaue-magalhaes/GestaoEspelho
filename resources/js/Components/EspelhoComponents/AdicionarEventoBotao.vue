<script setup lang="ts">
import { Promotor } from '@/types';
import { ref, onMounted } from 'vue';

import { Input } from '@/Components/ui/input';
import { Label } from '@/Components/ui/label';
import { Button } from '@/Components/ui/button';
import DatePicker from '@/Components/DatePicker.vue';
import { Dialog, DialogContent, DialogTrigger, DialogHeader, DialogTitle, DialogDescription, DialogFooter } from '@/Components/ui/dialog';
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue} from '@/Components/ui/select';

const emit = defineEmits([
    'update:adicionaEvento',
]);

const props = defineProps({
    promotores: {
        type: Array as () => Promotor[] ,
        required: true,
    },
    nomePromotoria: {
        type: String,
        required: true,
    },
    nomeMunicipio: {
        type: String,
        required: true,
    },
    nomePromotor: {
        type: String,
        required: true,
    },
});

/* Variaveis Reativas */
const tipoEvento = ref<string>('');
const periodoEvento = ref<{ start: Date; end: Date }>({ start: new Date(), end: new Date() });
const tituloEvento = ref<string>('');
const promotorDesignadoEvento = ref<string>('');
const tipoEventoInvalido = ref<boolean>(false);
const periodoEventoInvalido = ref<boolean>(false);
const periodoEventoAlterado = ref<boolean>(false);
const promotorDesignadoEventoInvalido = ref<boolean>(false);
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
  promotorDesignadoEventoInvalido.value = promotorDesignadoEvento.value === '';

  return !tipoEventoInvalido.value && !periodoEventoInvalido.value && !promotorDesignadoEventoInvalido.value;
};

const resetarInformacoes = () => {
    dialogOpen.value = false;
    tipoEvento.value = '';
    periodoEvento.value = { start: new Date(), end: new Date() };
    tituloEvento.value = '';
    promotorDesignadoEvento.value = '';
    tipoEventoInvalido.value = false;
    periodoEventoInvalido.value = false;
    periodoEventoAlterado.value = false;
    promotorDesignadoEventoInvalido.value = false;

};

const updatePeriodo = (periodo: { start: Date; end: Date } | any, alterado: boolean) => {
    //console.log(periodo.start);
    if (periodo.start === undefined) {
        periodoEvento.value = periodo;
    } else {
        periodoEvento.value = { start: periodo.start, end: periodo.end };
    }
    periodoEventoAlterado.value = alterado;
};

const enviaDadosDoEvento = (evento: { tipo: string; periodo: { start: Date; end: Date }; titulo: string; promotorDesignadoEvento: string }) => {
    //console.log(evento);
    if (verificaSeDadosDoEventoSaoValidos()) {
        emit('update:adicionaEvento',props.nomePromotoria , props.nomeMunicipio, evento);
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
        <DialogContent class="w-full max-w-2xl">
            <DialogHeader>
                <DialogTitle>
                    Adicionar Evento
                </DialogTitle>
                <DialogDescription>
                    Adicione um evento para o Promotor de Justiça {{ nomePromotor }}.
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
                            :period="periodoEvento"
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
                        <Select class="mb-2 w-full" v-model="promotorDesignadoEvento">
                            <SelectTrigger :class="{ 'border-red-500 border-2 text-red-500': promotorDesignadoEventoInvalido }">
                                <SelectValue placeholder="Selecione o Promotor que foi designado" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectGroup>
                                    <SelectLabel>Promotores</SelectLabel>
                                    <SelectItem v-for="promotor in props.promotores" :key="promotor.id" :value="promotor.nome">
                                        {{ promotor.nome }}
                                    </SelectItem>
                                </SelectGroup>
                            </SelectContent>
                            <span v-if="promotorDesignadoEventoInvalido" class="text-red-500 text-sm">Selecione o Promotor designado</span>
                        </Select>
                    </div>
                </div>
            </div>
            <DialogFooter>
                <Button variant="destructive" @click="resetarInformacoes">
                    Cancelar
                </Button>
                <Button variant="default" @click="enviaDadosDoEvento({ tipo: tipoEvento, periodo: periodoEvento, titulo: tituloEvento, promotorDesignadoEvento: promotorDesignadoEvento })">
                    Adicionar Evento
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>