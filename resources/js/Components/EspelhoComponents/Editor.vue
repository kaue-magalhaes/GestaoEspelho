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

type Municipios = {
  nome: string;
  promotorias: {
    nome: string;
    nomePromotor: string;
    eventos: {
      id: number;
      tipo: string;
      periodo: string[];
      titulo: string;
      promotorDesignado: string;
    }[];
  }[];
};

const emit = defineEmits([
  'update:promotorias',
  'update:periodoEspelho',
  'update:promotorUrgencia',
  'update:periodoUrgencia',
  'remove:promotorUrgenciaItem',
  'update:novaAtribuicao',
  'update:municipiosDados',
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

const municipiosDados = ref<Municipios[]>([]);
const municipiosInterior = ref<Municipios[]>([]);

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

const updateMunicipiosDados = (municipio: Municipios) => {
  //console.log(municipiosDados.value);
  
  if (municipiosDados.value.length === 0) {
    municipiosDados.value.push({
      nome: municipio.nome,
      promotorias: municipio.promotorias,
    }); 
  } else {
    const indexMunicipio = municipiosDados.value.findIndex((m) => m.nome === municipio.nome);
    if (indexMunicipio === -1) {
      municipiosDados.value.push({
        nome: municipio.nome,
        promotorias: municipio.promotorias,
      });
    } else {
      const indexPromotoria = municipiosDados.value[indexMunicipio].promotorias.findIndex((p) => p.nome === municipio.promotorias[0].nome);
      if (indexPromotoria === -1) {
        municipiosDados.value[indexMunicipio].promotorias.push(municipio.promotorias[0]);
      } else {
        municipiosDados.value[indexMunicipio].promotorias[indexPromotoria].eventos.push(municipio.promotorias[0].eventos[0]);
      }
    }
  }

  //console.log(municipiosDados.value);
  
  emit('update:municipiosDados', municipiosDados.value);
};

const deleteEventoInterior = (eventoId: number, nomePromotoria: string) => {
  municipiosDados.value.forEach((municipio) => {
    municipio.promotorias.forEach((promotoria) => {
      if (promotoria.nome === nomePromotoria) {
        promotoria.eventos = promotoria.eventos.filter((evento) => evento.id !== eventoId);
      }
      if (promotoria.eventos.length === 0) {
        municipio.promotorias = municipio.promotorias.filter((p) => p.nome !== promotoria.nome);
      }
    });
    if (municipio.promotorias.length === 0) {
      municipiosDados.value = municipiosDados.value.filter((m) => m.nome !== municipio.nome);
    }
  });

  emit('update:municipiosDados', municipiosDados.value)
};
onMounted(() => {
  //console.log(promotoriasInterior.value);
  
  promotoriasInterior.value.forEach((promotoria) => {
    if (municipiosInterior.value.length === 0) {
      municipiosInterior.value.push({
        nome: promotoria.municipio,
        promotorias: [
          {
            nome: promotoria.nome,
            nomePromotor: promotoria.promotor.nome,
            eventos: [],
          },
        ],
      });
    } else {
      const indexMunicipio = municipiosInterior.value.findIndex((m) => m.nome === promotoria.municipio);
      if (indexMunicipio === -1) {
        municipiosInterior.value.push({
          nome: promotoria.municipio,
          promotorias: [
            {
              nome: promotoria.nome,
              nomePromotor: promotoria.promotor.nome,
              eventos: [],
            },
          ],
        });
      } else {
        const indexPromotoria = municipiosInterior.value[indexMunicipio].promotorias.findIndex((p) => p.nome === promotoria.nome);
        if (indexPromotoria === -1) {
          municipiosInterior.value[indexMunicipio].promotorias.push({
            nome: promotoria.nome,
            nomePromotor: promotoria.promotor.nome,
            eventos: [],
          });
        }
      }
    }
  });
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
          :municipiosInterior="municipiosInterior"
          @update:adicionaMunicipiosDados="updateMunicipiosDados"
          @delete:deleteEventoInterior="deleteEventoInterior"
        />
      </CardContent>
    </div>
  </Card>
</template>