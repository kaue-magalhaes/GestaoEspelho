<script setup>
import { ref, defineEmits, watch } from 'vue';
import { Button } from '@/Components/ui/button';
import { Label } from '@/Components/ui/label';
import { Input } from '@/Components/ui/input';
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue} from '@/Components/ui/select'
import { Card, CardContent, CardHeader, CardTitle } from '@/Components/ui/card';
import Calendar from 'primevue/calendar';
import { format } from 'date-fns';
import { Trash2 } from 'lucide-vue-next';

const periodoEspelho = ref(null);
const urgenciaInputComponent = ref([]);

const emit = defineEmits([
  'update:periodoEspelho',
  'update:promotorUrgencia',
  'update:periodoUrgencia',
  'remove:promotorUrgenciaItem',
]);

const adicionarInput = () => {
  urgenciaInputComponent.value.push({ 
    value: {
      promotorUrgencia: '',
      periodoUrgencia: '',
    }
  });
};

const removeInput = (index) => {
  urgenciaInputComponent.value.splice(index, 1);
  emit('remove:promotorUrgenciaItem', index);
};

const dateFormat = (date) => {
  return format(date, 'dd/MM/yyyy');
};

watch(periodoEspelho, (value) => {
  if (value[0] === null || value[1] === null) return [null, null];
  const dataInicio = value[0];
  const dataFinal = value[1];

  const dataInicioFormatada = dateFormat(dataInicio);
  const dataFinalFormatada = dateFormat(dataFinal);

  emit('update:periodoEspelho', [dataInicioFormatada, dataFinalFormatada]);
});
</script>

<template>
  <Card>
    <div class="max-w-5xl mx-auto">
      <CardHeader class="flex flex-row justify-between">
        <CardTitle class="font-semibold">
          Espelho do Ministério Público
        </CardTitle>
        <span class="flex items-end">
          <Label for="period" class="text-base mr-4">
            Período:
          </Label>
          <Calendar
            selectionMode="range"
            dateFormat="dd/mm/yy"
            inputId="period"
            showIcon
            placeholder="Selecione o período"
            v-model=periodoEspelho
            class="text-sm"
          />
        </span>
      </CardHeader>
  
      <CardContent>
        <div class="mt-8 flex flex-col space-y-4">
          <div class="grid grid-cols-2 gap-4">
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
                        <SelectItem v-for="promotor in $page.props.promotores.all" :key="promotor.id" :value="promotor.nome" @click="emit('update:promotorUrgencia', index, promotor.nome)">
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
                  <Calendar
                    dateFormat="dd/mm/yy"
                    showIcon
                    placeholder="Selecione o período"
                    v-model=input.value.periodoUrgencia
                    @update:modelValue="emit('update:periodoUrgencia', index, dateFormat(input.value.periodoUrgencia))"
                  />
                </div>
                <div class="flex mb-2">
                  <Button @click="removeInput(index)" variant="destructive" class="p-3">
                    <Trash2 class="w-5 h-5 text-white" />
                  </Button>
                </div>
              </div>
              <Button variant="ghost" class="w-1/4" @click="adicionarInput">
                Adicionar +
              </Button>
            </Card>
          </div>
        </div>
      </CardContent>
    </div>
  </Card>
</template>