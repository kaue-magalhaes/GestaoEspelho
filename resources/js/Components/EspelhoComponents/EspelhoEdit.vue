<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

import { Button } from '@/Components/ui/button';
import { Label } from '@/Components/ui/label';
import { Input } from '@/Components/ui/input';
import { Card, CardContent, CardHeader, CardTitle } from '@/Components/ui/card';
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue} from '@/Components/ui/select'
import { Dialog, DialogContent, DialogTrigger, DialogHeader, DialogTitle, DialogDescription } from '@/Components/ui/dialog';
import DatePicker from '@/Components/DatePicker.vue';

import { format } from 'date-fns';
import EntranciaFinalMacapa from './EntranciaFinalMacapa.vue';

const promotores = usePage().props.promotores;
const promotorias = usePage().props.promotorias;

const periodoEspelho = ref({
  isChanged: false,
  start: new Date(),
  end: new Date(),
});

const emit = defineEmits([
  'update:periodoEspelho',
  'update:promotorUrgencia',
  'update:periodoUrgencia',
  'remove:promotorUrgenciaItem',
]);

const updatePeriodoEspelho = (value: { start: Date; end: Date }) => {
  periodoEspelho.value.isChanged = true;
  periodoEspelho.value.start = value.start;
  periodoEspelho.value.end = value.end;

  emit('update:periodoEspelho', [format(periodoEspelho.value.start, 'dd/MM/yyyy'), format(periodoEspelho.value.end, 'dd/MM/yyyy')]);
};

const promotorUrgencia = (index: number, value: string) => {
  emit('update:promotorUrgencia', index, value);
};

const periodoUrgencia = (index: number, value: Date) => {
  emit('update:periodoUrgencia', index, format(value, 'dd/MM/yyyy'));
};

const removePromotorUrgenciaItem = (index: number) => {
  emit('remove:promotorUrgenciaItem', index);
};
</script>

<template>
  <Card>
    <div class="max-w-5xl mx-auto">
      <CardHeader class="flex flex-row items-center justify-between">
        <CardTitle class="font-semibold">
          Espelho do Ministério Público
        </CardTitle>
        <span class="flex items-center">
          <Label for="period" class="text-base mr-4">
            Período:
          </Label>
          <DatePicker 
            v-model="periodoEspelho"
            :range="true"
            @update:period="updatePeriodoEspelho"
          />
        </span>
      </CardHeader>
  
      <CardContent>
        <EntranciaFinalMacapa
          :promotores="promotores"
          :promotorias="promotorias"
          @update:promotor-urgencia="promotorUrgencia"
          @update:periodo-urgencia="periodoUrgencia"
          @remove:promotor-urgencia-item="removePromotorUrgenciaItem"
        />
      </CardContent>
    </div>
  </Card>
</template>