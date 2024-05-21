<script setup lang="ts">
import {Promotor} from "@/Interfaces/Promotor/Promotor";
import {format} from 'date-fns';

import {Plus, Trash} from 'lucide-vue-next';
import {useUrgenciaAtendimentosStore} from "@/stores/urgenciaAtendimentoStore";
import {storeToRefs} from "pinia";

const store = useUrgenciaAtendimentosStore();
const { urgenciaAtendimentos, loading } = storeToRefs(store);

const props = defineProps({
    promotores: {
        type: Array as () => Promotor[],
        required: true,
    },
});

// const plantaoDeAtendimentos = ref<UrgenciaAtendimento[]>(props.urgenciaAtendimentos);

const adicionarInputDeDados = () => {
    // if (plantaoDeAtendimentos.value.length === 0) {
    //     plantaoDeAtendimentos.value.push({
    //         id: '1',
    //         periodo_inicio: '',
    //         periodo_fim: '',
    //         promotor_designado_id: '',
    //     });
    // } else {
    //     if (plantaoDeAtendimentos.value[plantaoDeAtendimentos.value.length - 1].periodo_inicio !== '' && plantaoDeAtendimentos.value[plantaoDeAtendimentos.value.length - 1].periodo_fim !== '' && plantaoDeAtendimentos.value[plantaoDeAtendimentos.value.length - 1].promotor_designado_id !== '') {
    //         plantaoDeAtendimentos.value.push({
    //             id: (parseInt(plantaoDeAtendimentos.value[plantaoDeAtendimentos.value.length - 1].id) + 1).toString(),
    //             periodo_inicio: '',
    //             periodo_fim: '',
    //             promotor_designado_id: '',
    //         });
    //     }
    // }
};

const adicionaNomeDoPromotorSelecionado = (index: number, idPromotor: string) => {
    //plantaoDeAtendimentos.value[index].promotor_designado_id = idPromotor;
    ////emit('update:nomeFoiSelecionado', index, idPromotor);
};

const adicionaPeriodoDeAtendimentoSelecionado = (index: number, periodo: { start: Date; end: Date }) => {
    const periodo_inicio = format(periodo.start, 'yyyy-MM-dd');
    const periodo_fim = format(periodo.end, 'yyyy-MM-dd');
    //plantaoDeAtendimentos.value[index].periodo_inicio = periodo_inicio;
    //plantaoDeAtendimentos.value[index].periodo_fim = periodo_fim;
    //emit('update:periodoDoAtendimentoFoiSelecionado', index, periodo_inicio, periodo_fim);
};

const removeInputDeDados = (index: number) => {
    //plantaoDeAtendimentos.value.splice(index, 1);
    //emit('delete:inputDeDadosFoiDeletado', index);
};

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
            v-for="(dados, index) in urgenciaAtendimentos.data" :key="index"
        >
            <div class="flex flex-row items-center w-full space-x-4">
                <Label class="text-base whitespace-nowrap">
                    Promotor:
                </Label>
                <Select v-model="dados.promotor_designado_id">
                    <SelectTrigger>
                        <SelectValue placeholder="Selecione o Promotor"/>
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectLabel>Promotores</SelectLabel>
                            <SelectItem
                                v-for="promotor in promotores" :key="promotor.id"
                                :value="promotor.id"

                                @click="adicionaNomeDoPromotorSelecionado(index, promotor.id)"
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
                    v-if="dados.periodo_fim && dados.periodo_inicio"
                    :period_start="new Date(dados.periodo_inicio)"
                    :period_end="new Date(dados.periodo_fim)"
                    :was-changed="true"
                    @update:period="adicionaPeriodoDeAtendimentoSelecionado(index, $event)"
                />
                <DatePicker
                    v-else
                    :was-changed="false"
                    @update:period="adicionaPeriodoDeAtendimentoSelecionado(index, $event)"
                />
            </div>
            <div class="flex">
                <Button @click="removeInputDeDados(index)" variant="destructive" size="icon">
                    <Trash class="w-4 h-4"/>
                </Button>
            </div>
        </div>
        <Button variant="ghost" class="w-1/3" @click="adicionarInputDeDados()">
            Adicionar
            <Plus class="ml-1 w-4 h-4"/>
        </Button>
    </Card>
</template>
