<script setup lang="ts">
import { Promotor, Promotoria } from '@/types';
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';

import { Label } from '@/Components/ui/label';
import DatePicker from '@/Components/DatePicker.vue';
import { Card, CardContent, CardHeader, CardTitle } from '@/Components/ui/card';

import { format } from 'date-fns';
import EntranciaFinalMacapaEditor from './EditorComponents/EntranciaFinalMacapaEditor.vue';
import EntranciaFinalSantanaEditor from './EditorComponents/EntranciaFinalSantanaEditor.vue';
import EntranciaInicialEditor from './EditorComponents/EntranciaInicialEditor.vue';
import TabelaPromotoresSubstitutosEditor from '@/Components/EspelhoComponents/EditorComponents/TabelaPromotoresSubstitutosEditor.vue';

const promotores = usePage().props.promotores;
const promotorias = usePage().props.promotorias;

const emit = defineEmits([
  'update:promotorias',
  'update:periodoEspelho',
  'update:promotorUrgencia',
  'update:periodoUrgencia',
  'remove:promotorUrgenciaItem',
  '@update:nova-atribuicao',
]);

const periodoEspelho = ref({
  isChanged: false,
  start: new Date(),
  end: new Date(),
});

const updatePeriodoEspelho = (value: { start: Date; end: Date }) => {
  periodoEspelho.value.isChanged = true;
  periodoEspelho.value.start = value.start;
  periodoEspelho.value.end = value.end;

  emit('update:periodoEspelho', [format(periodoEspelho.value.start, 'dd/MM/yyyy'), format(periodoEspelho.value.end, 'dd/MM/yyyy')]);
};

const updatePromotorias = (value: { all: Promotoria[] }) => {
  emit('update:promotorias', value);
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
        <!-- <EntranciaFinalMacapaEditor
          :promotores="promotores"
          :promotorias="promotorias"
        />
        <EntranciaFinalSantanaEditor
          :promotores="promotores"
          :promotorias="promotorias"
        />
        <EntranciaInicialEditor
          :promotores="promotores"
          :promotorias="promotorias"
        /> -->
      </CardContent>
    </div>
  </Card>
</template>