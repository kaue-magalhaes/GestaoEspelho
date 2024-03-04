<script setup lang="ts">
import {AtendimentoUrgencia, Promotor} from '@/types';
import { ref, onMounted } from 'vue';

import { Button } from '@/Components/ui/button';
import { Label } from '@/Components/ui/label';
import { Card } from '@/Components/ui/card';
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue} from '@/Components/ui/select'
import DatePicker from '@/Components/DatePicker.vue';

import { Plus, Trash2 } from 'lucide-vue-next';

const emit = defineEmits([
  'update:promotorNome',
  'update:periodoAtendimento',
  'remove:atendimentoUrgenciaValues',
]);

const props = defineProps({
  promotores: {
    type: Array as () => Promotor[] ,
    required: true,
  },
});

const urgenciaInputComponent = ref<AtendimentoUrgencia[]>([]);

const adicionarInput = () => {
  urgenciaInputComponent.value.push({
    id: urgenciaInputComponent.value.length,
    nome_promotor: '',
    periodo: { start: new Date, end: new Date },
  });
  console.log(urgenciaInputComponent.value);
};

const removeInput = (index: number) => {
  //remove o valor com o index passado e atualiza o index dos demais valores
  urgenciaInputComponent.value.splice(index, 1);
  urgenciaInputComponent.value.forEach((item, index) => {
    item.id = index;
  });
  emit('remove:atendimentoUrgenciaValues', index);
  //console.log(urgenciaInputComponent.value);
};

const enviaNomePromotor = (id: number, nome: string) => {
  urgenciaInputComponent.value[id].nome_promotor = nome;
  emit('update:promotorNome', id, nome);
};

const emitirPeriodo = (id: number, periodo: { start: Date; end: Date }) => {
  urgenciaInputComponent.value[id].periodo = periodo;
  emit('update:periodoAtendimento', id, periodo);
};

onMounted(() => {
  //console.log(props.promotores);
});
</script>

<template>
  <Card class="col-span-2 flex flex-col py-4 items-center space-y-2 w-full">
    <Label class="text-xl">
      Plantão de Atendimentos em Caráter de Urgência - Macapá/Santana:
    </Label>
    <div v-for="input in urgenciaInputComponent" :key="input.id" class="w-full px-4 flex justify-center items-center space-x-4">
      <div class="flex flex-row items-center w-full space-x-4">
        <Label class="text-base whitespace-nowrap">
          Nome do Promotor:
        </Label>
        <Select v-model="input.nome_promotor" class="mb-2 w-full">
          <SelectTrigger>
            <SelectValue placeholder="Selecione o promotor" />
          </SelectTrigger>
          <SelectContent>
            <SelectGroup>
              <SelectLabel>Promotores</SelectLabel>
              <SelectItem v-for="promotor in props.promotores" :key="promotor.id" :value="promotor.nome" @click="enviaNomePromotor(input.id, promotor.nome)">
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
          v-model.range="input.periodo"
          :period="input.periodo"
          :range="true"
          @update:period="emitirPeriodo(input.id, $event)"
        />
      </div>
      <div class="flex mb-2">
        <Button @click="removeInput(input.id)" variant="destructive" class="p-3">
          <Trash2 class="w-5 h-5 text-white" />
        </Button>
      </div>
    </div>
    <Button variant="ghost" class="w-1/4" @click="adicionarInput">
      Adicionar <Plus class="ml-1 w-4 h-4" />
    </Button>
    </Card>
</template>
