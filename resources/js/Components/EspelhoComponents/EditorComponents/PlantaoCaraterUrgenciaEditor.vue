<script setup lang="ts">
import {Promotor, UrgenciaAtendimento} from '@/types';
import {onMounted, ref} from 'vue';
import { format } from 'date-fns';

import { Button } from '@/Components/ui/button';
import { Label } from '@/Components/ui/label';
import { Card } from '@/Components/ui/card';
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue} from '@/Components/ui/select'
import DatePicker from '@/Components/DatePicker.vue';

import { Plus, Trash2 } from 'lucide-vue-next';
import {usePage} from "@inertiajs/vue3";

const page = usePage();
const emit = defineEmits([
  'delete:inputDeDadosFoiDeletado',
  'update:nomeFoiSelecionado',
  'update:periodoDoAtendimentoFoiSelecionado',
]);

const promotoresQuePodemAtender = ref<Promotor[]>(page.props.promotores || []);
const plantaoDeAtendimentos = ref<UrgenciaAtendimento[]>(page.props.urgenciaAtendimentos || []);

const adicionarInputDeDados = () => {
  plantaoDeAtendimentos.value.push({
    id: String(Number(plantaoDeAtendimentos.value[plantaoDeAtendimentos.value.length - 1].id) + 1),
    periodo_inicio: '',
    periodo_fim: '',
    promotor_designado_id: '',
  });
};

const adicionaNomeDoPromotorSelecionado = (index: number, nomePromotor: string, idPromotor: string) => {
  plantaoDeAtendimentos.value[index].promotor_designado_id = idPromotor;
  emit('update:nomeFoiSelecionado', index, nomePromotor, idPromotor);
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
              <SelectItem v-for="promotor in promotoresQuePodemAtender" :key="promotor.id" :value="promotor.id" @click="adicionaNomeDoPromotorSelecionado(index, promotor.nome, promotor.id)">
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
          :period_start="new Date(input.periodo_inicio)"
          :period_end="new Date (input.periodo_fim)"
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
      <div class="flex mb-2">
        <Button @click="removeInputDeDados(index)" variant="destructive" class="p-3">
          <Trash2 class="w-5 h-5 text-white" />
        </Button>
      </div>
    </div>
    <Button variant="ghost" class="w-1/4" @click="adicionarInputDeDados()">
      Adicionar <Plus class="ml-1 w-4 h-4" />
    </Button>
    </Card>
</template>
