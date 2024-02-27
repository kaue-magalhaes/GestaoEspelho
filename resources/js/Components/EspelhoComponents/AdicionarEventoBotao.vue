<script setup lang="ts">
import { Promotoria, Promotor } from '@/types';
import { ref, onMounted } from 'vue';

import { Input } from '@/Components/ui/input';
import { Label } from '@/Components/ui/label';
import { Button } from '@/Components/ui/button';
import DatePicker from '@/Components/DatePicker.vue';
import { Dialog, DialogContent, DialogTrigger, DialogHeader, DialogTitle, DialogDescription, DialogFooter, DialogClose } from '@/Components/ui/dialog';
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue} from '@/Components/ui/select';

const emit = defineEmits([
    'update:adicionaEvento',
]);

const props = defineProps({
    promotoriaKey: {
        type: String,
        required: true,
    },
    promotoria: {
        type: Object as () => Promotoria,
        required: true,
    },
    promotores: {
        type: Array as () => Promotor[] ,
        required: true,
    },
});

const tipoEvento = ref<string>('');
const periodoEvento = ref<{ start: Date; end: Date }>({ start: new Date(), end: new Date() });
const tituloEvento = ref<string>('');
const promotorDesignado = ref<string>('');

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
  promotorDesignado.value = '';
};

const adicionaEvento = (promotoriaKey: string, promotoria_id: number, evento: { tipo: string; periodo: { start: Date; end: Date }; titulo: string; promotorDesignado: string }) => {
  emit('update:adicionaEvento', promotoriaKey, promotoria_id, evento);
  resetarInformacoes();
};

onMounted(() => {
  //console.log(props.promotores);
});
</script>

<template>
    <Dialog>
        <DialogTrigger as-child>
            <Button variant="ghost" class="w-full mt-2">
                Adicionar Evento
            </Button>
        </DialogTrigger>
        <DialogContent class="w-full max-w-2xl">
            <DialogHeader>
                <DialogTitle>
                    Adicionar Evento
                </DialogTitle>
                <DialogDescription>
                    Adicione um evento para o Promotor de Justiça {{ promotoria.promotor.nome }}.
                </DialogDescription>
            </DialogHeader>
            <div class="flex flex-col space-y-4">
                <div class="flex items-center space-x-4">
                    <div class="w-1/2 space-y-1">
                        <Label class="text-base">
                            Tipo do Evento:
                        </Label>
                        <Select class="mb-2 w-full" v-model:="tipoEvento">
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
                        <Select class="mb-2 w-full" v-model="promotorDesignado">
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
                    <Button variant="destructive" @click="resetarInformacoes">
                        Cancelar
                    </Button>
                </DialogClose>
                <DialogClose as-child>
                    <Button variant="default" @click="adicionaEvento(promotoriaKey, promotoria.id, { tipo: tipoEvento, periodo: periodoEvento, titulo: tituloEvento, promotorDesignado: promotorDesignado })">
                        Adicionar Evento
                    </Button>
                </DialogClose>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>