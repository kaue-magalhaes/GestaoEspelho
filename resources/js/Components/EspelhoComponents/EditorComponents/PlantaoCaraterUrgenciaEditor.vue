<script setup lang="ts">
import {Promotor, UrgenciaAtendimentoServeSide} from '@/types';
import {onMounted, ref} from 'vue';
import { format } from 'date-fns';

import { Plus, Trash } from 'lucide-vue-next';
import {usePage} from "@inertiajs/vue3";

const page = usePage();
const emit = defineEmits([
  'delete:inputDeDadosFoiDeletado',
  'update:nomeFoiSelecionado',
  'update:periodoDoAtendimentoFoiSelecionado',
]);

const promotoresQuePodemAtender = ref<Promotor[]>(page.props.promotores || []);
const plantaoDeAtendimentos = ref<UrgenciaAtendimentoServeSide[]>(page.props.urgenciaAtendimentos || []);

const adicionarInputDeDados = () => {
  if (plantaoDeAtendimentos.value.length === 0) {
    plantaoDeAtendimentos.value.push({
      id: '1',
      periodo_inicio: '',
      periodo_fim: '',
      promotor_designado_id: '',
    });
  } else {
    if(plantaoDeAtendimentos.value[plantaoDeAtendimentos.value.length - 1].periodo_inicio !== '' && plantaoDeAtendimentos.value[plantaoDeAtendimentos.value.length - 1].periodo_fim !== '' && plantaoDeAtendimentos.value[plantaoDeAtendimentos.value.length - 1].promotor_designado_id !== '') {
      plantaoDeAtendimentos.value.push({
        id: (parseInt(plantaoDeAtendimentos.value[plantaoDeAtendimentos.value.length - 1].id) + 1).toString(),
        periodo_inicio: '',
        periodo_fim: '',
        promotor_designado_id: '',
      });
    }
  }
};

const adicionaNomeDoPromotorSelecionado = (index: number, idPromotor: string) => {
  plantaoDeAtendimentos.value[index].promotor_designado_id = idPromotor;
  emit('update:nomeFoiSelecionado', index, idPromotor);
};

const adicionaPeriodoDeAtendimentoSelecionado = (index: number, periodo: { start: Date; end: Date }) => {
  const periodo_inicio = format(periodo.start, 'yyyy-MM-dd');
  const periodo_fim = format(periodo.end, 'yyyy-MM-dd');
  plantaoDeAtendimentos.value[index].periodo_inicio = periodo_inicio;
  plantaoDeAtendimentos.value[index].periodo_fim = periodo_fim;
  emit('update:periodoDoAtendimentoFoiSelecionado', index, periodo_inicio, periodo_fim);
};

const removeInputDeDados = (index: number) => {
  plantaoDeAtendimentos.value.splice(index, 1);
  emit('delete:inputDeDadosFoiDeletado', index);
};

function stringToDate(dateString: string) {
  const [year, month, day] = dateString.split('-').map(Number);
  return new Date(year, month - 1, day);
}

onMounted(() => {
  //console.log(plantaoDeAtendimentos.value);
});
</script>

<template>
  <Card class="col-span-2 flex flex-col py-4 items-center space-y-2 w-full">
    <Label class="text-xl">
      Plantão de Atendimentos em Caráter de Urgência - Macapá/Santana:
    </Label>
    <div v-for="(input, index) in plantaoDeAtendimentos" :key="index" class="w-full px-4 flex justify-center items-center space-x-4">
      <div class="flex flex-row items-center w-full space-x-4">
        <Label class="text-base whitespace-nowrap">
          Nome do Promotor:
        </Label>
        <Select v-model="input.promotor_designado_id" class="w-1/2">
          <SelectTrigger>
            <SelectValue placeholder="Selecione o promotor" />
          </SelectTrigger>
          <SelectContent>
            <SelectGroup>
              <SelectLabel>Promotores</SelectLabel>
              <SelectItem v-for="promotor in promotoresQuePodemAtender" :key="promotor.id" :value="promotor.id" @click="adicionaNomeDoPromotorSelecionado(index, promotor.id)">
                {{ promotor.nome }}
              </SelectItem>
            </SelectGroup>
          </SelectContent>
        </Select>
      </div>
      <div class="flex flex-row items-center w-full space-x-4">
        <Label class="text-base">
          Período:
        </Label>
        <DatePicker
          v-if="input.periodo_fim !== '' && input.periodo_inicio !== ''"
          :period_start="stringToDate(input.periodo_inicio)"
          :period_end="stringToDate(input.periodo_fim)"
          :range="true"
          :was-changed="true"
          @update:period="adicionaPeriodoDeAtendimentoSelecionado(index, $event)"
        />
        <DatePicker
          v-else
          :range="true"
          :was-changed="false"
          @update:period="adicionaPeriodoDeAtendimentoSelecionado(index, $event)"
        />
      </div>
      <div class="flex">
        <Button @click="removeInputDeDados(index)" variant="destructive" size="icon">
          <Trash class="w-4 h-4" />
        </Button>
      </div>
    </div>
    <Button variant="ghost" class="w-1/4" @click="adicionarInputDeDados()">
      Adicionar <Plus class="ml-1 w-4 h-4" />
    </Button>
    </Card>
</template>
