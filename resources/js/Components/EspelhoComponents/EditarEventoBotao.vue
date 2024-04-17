<script setup lang="ts">
import { ref } from 'vue';
import { format } from 'date-fns';

import { Edit } from 'lucide-vue-next';
import {Promotor} from "@/Interfaces/Promotor";
import {GrupoPromotoria} from "@/Interfaces/GrupoPromotoria";
import {Promotoria} from "@/Interfaces/Promotoria";
import {Evento} from "@/Interfaces/Evento";

const emit = defineEmits([
    'update:editaEvento',
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
    evento: {
        type: Object as () => Evento,
        required: true,
    },
});

/* Variaveis Reativas */
const tipoEvento = ref<string>(props.evento?.tipo);
const periodoEvento = ref<{ start: Date; end: Date }>({ start: stringToDate(props.evento?.periodo_inicio), end: stringToDate(props.evento?.periodo_fim) });
const tituloEvento = ref<string>(props.evento?.titulo || '');
const promotor_designado_id = ref<string>(props.evento?.promotor_designado_id);
const dialogOpen = ref<boolean>(false);

const eventos = [
    { id: 1, nome: 'Férias', selecionado: false },
    { id: 2, nome: 'Licença', selecionado: false },
    { id: 3, nome: 'Plantão', selecionado: false },
    { id: 4, nome: 'Reunião', selecionado: true },
    { id: 5, nome: 'Outros', selecionado: false },
];

const enviaDadosDoEvento = (
    grupoPromotoriaID: string,
    promotoriaID: string,
    evento: {
        id?: string;
        uuid?: string;
        titulo: string;
        tipo: string;
        periodo: { start: Date; end: Date };
        promotor_titular_id: string;
        promotor_designado_id: string
    }
) => {
    const novoEvento = {
        id: evento.id,
        uuid: evento.uuid,
        titulo: evento.titulo,
        tipo: evento.tipo,
        periodo_inicio: format(evento.periodo.start, 'yyyy-MM-dd'),
        periodo_fim: format(evento.periodo.end, 'yyyy-MM-dd'),
        promotor_titular_id: evento.promotor_titular_id,
        promotor_designado_id: evento.promotor_designado_id,
    };
    emit('update:editaEvento', grupoPromotoriaID, promotoriaID, novoEvento);
    dialogOpen.value = false;
};

function stringToDate(dateString: string) {
  const [year, month, day] = dateString.split('-').map(Number);
  return new Date(year, month - 1, day);
}
</script>

<template>
    <Dialog :open="dialogOpen">
        <DialogTrigger as-child>
          <Button variant="outline" size="icon" @click="dialogOpen = true">
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
                            :period_start="periodoEvento.start"
                            :period_end="periodoEvento.end"
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
                        <Select class="mb-2 w-full" v-model="promotor_designado_id">
                            <SelectTrigger>
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
                        </Select>
                    </div>
                </div>
            </div>
            <DialogFooter>
                <Button variant="destructive" @click="dialogOpen = false">
                    Cancelar
                </Button>
                <Button
                    variant="default"
                    @click="enviaDadosDoEvento(
                        props.grupoPromotoria?.id,
                        props.promotoria?.id,
                        {
                            id: props.evento?.id,
                            uuid: props.evento?.uuid,
                            tipo: tipoEvento,
                            periodo: periodoEvento,
                            titulo: tituloEvento,
                            promotor_titular_id: props.evento?.promotor_titular_id,
                            promotor_designado_id: promotor_designado_id
                        }
                    )"
                >
                    Editar Evento
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
