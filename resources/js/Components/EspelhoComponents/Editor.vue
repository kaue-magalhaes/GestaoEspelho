<script setup lang="ts">
import { Promotor, Promotoria } from '@/types';
import { ref, onMounted, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

import { Label } from '@/Components/ui/label';
import DatePicker from '@/Components/DatePicker.vue';
import { Card, CardContent, CardHeader, CardTitle } from '@/Components/ui/card';

import { format } from 'date-fns';
import EntranciaFinalMacapaEditor from './EditorComponents/EntranciaFinalMacapaEditor.vue';
import EntranciaFinalSantanaEditor from './EditorComponents/EntranciaFinalSantanaEditor.vue';
import EntranciaInicialEditor from './EditorComponents/EntranciaInicialEditor.vue';
import TabelaPromotoresSubstitutosEditor from '@/Components/EspelhoComponents/EditorComponents/TabelaPromotoresSubstitutosEditor.vue';

const emit = defineEmits([
  'update:promotorias',
  'update:periodoEspelho',
  'update:promotorUrgencia',
  'update:periodoUrgencia',
  'remove:promotorUrgenciaItem',
  'update:novaAtribuicao',
  'update:promotoriasInteriorEventos',
]);

const props = defineProps({
  promotorias: {
    type: Array as () => Promotoria[],
    required: true,
  },
  promotores: {
    type: Array as () => Promotor[],
    required: true,
  },
});

const promotoriasInterior = computed(() => {
  return props.promotorias.filter((promotoria) => promotoria.municipio !== 'Macapá' && promotoria.municipio !== 'Santana');
});

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

const updatePromotoriasInteriorEventos = (unidade: Promotoria, evento: { tipo: string; periodo: { start: Date; end: Date }; titulo: string; promotorDesignado: string }) => {
  //console.log(unidade);
  const eventoFormatado = {
    tipo: evento.tipo,
    periodo: [format(evento.periodo.start, 'dd/MM/yyyy'), format(evento.periodo.end, 'dd/MM/yyyy')],
    titulo: evento.titulo,
    promotorDesignado: evento.promotorDesignado,
  };
  
  const value = { promotoria: unidade, eventoFormatado };

  emit('update:promotoriasInteriorEventos', value);
};
onMounted(() => {
  //console.log(props.promotorias);
  //console.log(promotoriasInterior.value);
});
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
        /> -->
        <EntranciaInicialEditor
          :promotoriasInterior="promotoriasInterior"
          @update:adicionaEvento="updatePromotoriasInteriorEventos"
        />
      </CardContent>
    </div>
  </Card>
</template>