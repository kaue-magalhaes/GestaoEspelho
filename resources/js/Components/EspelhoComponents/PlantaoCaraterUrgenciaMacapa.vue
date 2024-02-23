<script setup lang="ts">
import { Promotor } from '@/types';
import { ref, onMounted } from 'vue';

import { Button } from '@/Components/ui/button';
import { Label } from '@/Components/ui/label';
import { Card } from '@/Components/ui/card';
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue} from '@/Components/ui/select'
import DatePicker from '@/Components/DatePicker.vue';

import { Plus, Trash2 } from 'lucide-vue-next';

const emit = defineEmits([
  'update:promotorUrgencia',
  'update:periodoUrgencia',
  'remove:promotorUrgenciaItem',
]);

const props = defineProps({
  promotores: {
    type: Object as () => { all: Promotor[]; },
    required: true,
  },
});

const urgenciaInputComponent = ref<any[]>([]);

const adicionarInput = () => {
  urgenciaInputComponent.value.push({ 
    value: {
      promotorUrgencia: '',
      periodoUrgencia: { start: new Date, end: new Date },
    }
  });  
};

const removeInput = (index: number) => {
  urgenciaInputComponent.value.splice(index, 1);
  emit('remove:promotorUrgenciaItem', index);
};
</script>

<template>
  <Card class="col-span-2 flex flex-col py-4 items-center space-y-2 w-full">
        <Label class="text-xl">
          Plantão de Atendimentos em Caráter de Urgência - Macapá:
        </Label>
        <div v-for="(input, index) in urgenciaInputComponent" :key="index" class="w-full px-4 flex justify-center items-center space-x-4">
          <div class="flex flex-row items-center w-full space-x-4">
            <Label class="text-base whitespace-nowrap">
              Nome do Promotor:
            </Label>
            <Select v-model="input.value.promotorUrgencia" class="mb-2 w-full">
              <SelectTrigger>
                <SelectValue placeholder="Selecione o promotor" />
              </SelectTrigger>
              <SelectContent>
                <SelectGroup>
                  <SelectLabel>Promotores</SelectLabel>
                  <SelectItem v-for="promotor in props.promotores.all" :key="promotor.id" :value="promotor.nome" @click="emit('update:promotorUrgencia', index, promotor.nome)">
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
              v-model="input.value.periodoUrgencia"
              @update:period="emit('update:periodoUrgencia', index, $event)"
            />
          </div>
          <div class="flex mb-2">
            <Button @click="removeInput(index)" variant="destructive" class="p-3">
              <Trash2 class="w-5 h-5 text-white" />
            </Button>
          </div>
        </div>
        <Button variant="ghost" class="w-1/4" @click="adicionarInput">
          Adicionar <Plus class="ml-1 w-4 h-4" />
        </Button>
    </Card>
</template>