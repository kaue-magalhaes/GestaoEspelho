<script setup lang="ts">
import { Promotor} from '@/types';
import { onMounted } from 'vue';

import { Button } from '@/Components/ui/button';
import { Label } from '@/Components/ui/label';
import { Card } from '@/Components/ui/card';
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue} from '@/Components/ui/select'
import DatePicker from '@/Components/DatePicker.vue';

import { Plus, Trash2 } from 'lucide-vue-next';

const emit = defineEmits([
  'update:promotorNome',
  'update:periodoAtendimento',
  'update:adicionaInput',
  'delete:removeInput',
  'delete:atendimentoUrgenciaValues',
]);

const props = defineProps({
  promotores: {
    type: Array as () => Promotor[] ,
    required: true,
  },
  urgenciaInputComponent: {
    type: Array as () => { nome_promotor: string; periodo: any }[],
    required: true,
  },
});

const adicionarInput = () => {
  //console.log('Adicionando input');
  const novoAtendimentoUrgencia = {
    nome_promotor: '',
    periodo: {
      start: null,
      end: null,
    },
  };
  emit('update:adicionaInput', novoAtendimentoUrgencia);
};

const removeInput = (index: number) => {
  //console.log('Removendo input do index: ', index);
  emit('delete:removeInput', index);
  emit('delete:atendimentoUrgenciaValues', index);
  //console.log(urgenciaInputComponent.value);
};

const enviaNomePromotor = (index: number, nome: string) => {
  //console.log(index, nome);
  emit('update:promotorNome', index, nome);
};

const emitirPeriodo = (index: number, periodo: { start: Date; end: Date }) => {
  //console.log(index, periodo);
  emit('update:periodoAtendimento', index, periodo);
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
    <div v-for="(input, index) in props.urgenciaInputComponent" :key="index" class="w-full px-4 flex justify-center items-center space-x-4">
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
              <SelectItem v-for="promotor in props.promotores" :key="promotor.id" :value="promotor.nome" @click="enviaNomePromotor(index, promotor.nome)">
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
          :period="input.periodo"
          :range="true"
          :was-changed="true"
          @update:period="emitirPeriodo(index, $event)"
        />
      </div>
      <div class="flex mb-2">
        <Button @click="removeInput(index)" variant="destructive" class="p-3">
          <Trash2 class="w-5 h-5 text-white" />
        </Button>
      </div>
    </div>
    <Button variant="ghost" class="w-1/4" @click="adicionarInput()">
      Adicionar <Plus class="ml-1 w-4 h-4" />
    </Button>
    </Card>
</template>
