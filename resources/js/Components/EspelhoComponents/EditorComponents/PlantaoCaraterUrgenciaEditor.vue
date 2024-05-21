<script setup lang="ts">
import {Promotor} from "@/Interfaces/Promotor/Promotor";
import {useUrgenciaAtendimentosStore} from "@/stores/urgenciaAtendimentoStore";
import {storeToRefs} from "pinia";
import {updateAnyPeriodo} from "@/utils/updatePeriodo";

import {Plus, Trash} from 'lucide-vue-next';

const store = useUrgenciaAtendimentosStore();
const {
    urgenciaAtendimentos,
    loading
} = storeToRefs(store);
const {
    addNewUrgenciaAtendimento,
    removeUrgenciaAtendimento,
    removeDataNotChanged,
    existsInErrosArray,
} = store;

const props = defineProps({
    promotores: {
        type: Array as () => Promotor[],
        required: true,
    },
});
</script>

<template>
    <div v-if="loading" class="w-full">
        esperando...
    </div>
    <Card
        v-else
        class="col-span-2 flex flex-col py-4 items-center space-y-2 w-full"
    >
        <Label class="text-xl mb-2">
            Plantão de Atendimentos em Caráter de Urgência - Macapá/Santana
        </Label>
        <div
            class="w-full px-4 flex justify-center items-center space-x-4"
            v-for="(data, index) in urgenciaAtendimentos.data" :key="index"
        >
            <div class="flex flex-row items-center w-full space-x-4">
                <Label class="text-base whitespace-nowrap">
                    Promotor:
                </Label>
                <Select v-model="data.promotor_designado_id">
                    <SelectTrigger :class="{'border border-red-600 text-red-600': existsInErrosArray(data.id)}">
                        <SelectValue placeholder="Selecione o Promotor"/>
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectLabel>Promotores</SelectLabel>
                            <SelectItem
                                v-for="promotor in promotores" :key="promotor.id"
                                @click="removeDataNotChanged(data.id)"
                                :value="promotor.id"
                            >
                                {{ promotor.nome }}
                            </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
            </div>
            <div class="flex flex-row items-center w-1/2 space-x-4">
                <Label class="text-base">
                    Período:
                </Label>
                <DatePicker
                    :period_start="data.periodo_inicio ? new Date(data.periodo_inicio) : null"
                    :period_end="data.periodo_fim ? new Date(data.periodo_fim) : null"
                    :was-changed="!!(data.periodo_fim && data.periodo_inicio)"
                    @update:period="updateAnyPeriodo(data, $event)"
                />
            </div>
            <div class="flex">
                <Button @click="removeUrgenciaAtendimento(data.id)" variant="destructive" size="icon">
                    <Trash class="w-4 h-4"/>
                </Button>
            </div>
        </div>
        <Button variant="ghost" class="w-1/3" @click="addNewUrgenciaAtendimento">
            Adicionar
            <Plus class="ml-1 w-4 h-4"/>
        </Button>
    </Card>
</template>
