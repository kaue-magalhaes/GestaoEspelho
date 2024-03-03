<script setup lang="ts">
import { Promotor } from '@/types';
import { ref, onMounted } from 'vue';

import { Input } from '@/Components/ui/input';
import { Label } from '@/Components/ui/label';
import { Button } from '@/Components/ui/button';
import DatePicker from '@/Components/DatePicker.vue';
import { Dialog, DialogContent, DialogTrigger, DialogHeader, DialogTitle, DialogDescription, DialogFooter, DialogClose } from '@/Components/ui/dialog';
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue} from '@/Components/ui/select';

import { Edit } from 'lucide-vue-next';


const emit = defineEmits([
    'update:editaEvento',
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
    id: {
        type: Number,
        required: true,
    },
    tipo: {
        type: String,
        required: true,
    },
    periodo: {
        type: Array as () => Date[],
        required: true,
    },
    titulo: {
        type: String,
        required: true,
    },
    promotor_designado_evento: {
        type: String,
        required: true,
        default: '',
    },
});

/* Variaveis Reativas */
const tipoEvento = ref<string>(props.tipo);
const periodoEvento = ref<{ start: Date; end: Date }>({ start: new Date(props.periodo[0]), end: new Date(props.periodo[1]) });
const tituloEvento = ref<string>(props.titulo);
const promotor_designado_evento_reativo = ref<string>(props.promotor_designado_evento);

const eventos = [
    { id: 1, nome: 'Férias', selecionado: false },
    { id: 2, nome: 'Licença', selecionado: false },
    { id: 3, nome: 'Plantão', selecionado: false },
    { id: 4, nome: 'Reunião', selecionado: true },
    { id: 5, nome: 'Outros', selecionado: false },
];

const resetarInformacoes = () => {
    tipoEvento.value = '';
    periodoEvento.value = { start: new Date(), end: new Date() };
    tituloEvento.value = '';
    promotor_designado_evento_reativo.value = '';
};

const enviaDadosDoEvento = (evento: { id: number; tipo: string; periodo: { start: Date; end: Date }; titulo: string; promotor_designado_evento: string }) => {
    console.log(evento);
    emit('update:editaEvento',props.nomePromotoria, evento);
};

onMounted(() => {
    //console.log(periodoEvento.value);
});
</script>

<template>
    <Dialog>
        <DialogTrigger as-child>
          <Button variant="outline" size="icon">
            <Edit class="w-4 h-4" />
          </Button>
        </DialogTrigger>
        <DialogContent class="w-full max-w-2xl">
            <DialogHeader>
                <DialogTitle>
                    Editar Evento
                </DialogTitle>
                <DialogDescription>
                    Edite as informações do evento
                </DialogDescription>
            </DialogHeader>
            <div class="flex flex-col space-y-4">
                <div class="flex items-center space-x-4">
                    <div class="w-1/2 space-y-1">
                        <Label class="text-base">
                            Tipo do Evento:
                        </Label>
                        <Select class="mb-2 w-full" v-model="tipoEvento">
                            <SelectTrigger>
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
                        </Select>
                    </div>
                    <div class="w-1/2 space-y-1">
                        <Label class="text-base">
                            Período:
                        </Label>
                        <DatePicker
                            :was-changed="true"
                            :range="true"
                            :period="periodoEvento"
                            @update:period="periodoEvento = $event"
                        />
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="w-1/2 space-y-1">
                        <Label class="text-base">
                            Título do Evento:
                        </Label>
                        <Input type="text" placeholder="Digite o título do evento" v-model="tituloEvento" />
                    </div>
                    <div class="w-1/2 space-y-1">
                        <Label class="text-base">
                            Promotor designado:
                        </Label>
                        <Select class="mb-2 w-full" v-model="promotor_designado_evento_reativo">
                            <SelectTrigger>
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
                        </Select>
                    </div>
                </div>
            </div>
            <DialogFooter>
                <DialogClose as-child>
                    <Button variant="destructive">
                        Cancelar
                    </Button>
                </DialogClose>
                <DialogClose as-child>
                    <Button variant="default" @click="enviaDadosDoEvento({id: props.id, tipo: tipoEvento, periodo: periodoEvento, titulo: tituloEvento, promotor_designado_evento: promotor_designado_evento_reativo })">
                        Editar Evento
                    </Button>
                </DialogClose>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>