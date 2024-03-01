<script setup lang="ts">
import { Promotor, Promotoria, GrupoPromotoria } from '@/types';
import { ref, onMounted, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

import { Label } from '@/Components/ui/label';
import DatePicker from '@/Components/DatePicker.vue';
import { Card, CardContent, CardHeader, CardTitle } from '@/Components/ui/card';

import { format } from 'date-fns';
import EntranciaFinalMacapaEditor from './EditorComponents/EntranciaFinalMacapaEditor.vue';
import EntranciaFinalSantanaEditor from './EditorComponents/EntranciaFinalSantanaEditor.vue';
import EntranciaInicialEditor from './EditorComponents/EntranciaInicialEditor.vue';

const emit = defineEmits([
  'update:promotorias',
  'update:periodoEspelho',
  'update:promotorUrgencia',
  'update:periodoUrgencia',
  'remove:promotorUrgenciaItem',
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
const promotoriasSantanaFiltro = computed(() => {
  return props.promotorias.filter((promotoria) => promotoria.municipio === 'Santana');
});

const periodoEspelho = ref({
  isChanged: false,
  start: new Date(),
  end: new Date(),
});
const municipiosDados = ref<GrupoPromotoria[]>([]);
const municipiosInterior = ref<GrupoPromotoria[]>([]);
const promotoriasSantana = ref<GrupoPromotoria[]>([]);

const updatePeriodoEspelho = (value: any) => {
  //console.log(typeof value);
  
  periodoEspelho.value.isChanged = true;
  if (value.start !== undefined) {
    periodoEspelho.value.start = value.start;
    periodoEspelho.value.end = value.end;

    emit('update:periodoEspelho', [format(periodoEspelho.value.start, 'dd/MM/yyyy'), format(periodoEspelho.value.end, 'dd/MM/yyyy')]);
  } else {
    periodoEspelho.value.start = new Date(value);
    //console.log(periodoEspelho.value);
    
    emit('update:periodoEspelho', format(value, 'dd/MM/yyyy'));
  }
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

const adicionaMunicipiosDados = (municipio: GrupoPromotoria) => {
  //console.log(municipiosDados.value);
  const municipiosConvertidos = convertMunicipios(municipio);

  if (municipiosDados.value.length === 0) {
    municipiosDados.value.push({
      nome: municipiosConvertidos.nome,
      promotorias: municipiosConvertidos.promotorias,
    }); 
  } else {
    const indexMunicipio = municipiosDados.value.findIndex((m) => m.nome === municipio.nome);
    if (indexMunicipio === -1) {
      municipiosDados.value.push({
        nome: municipiosConvertidos.nome,
        promotorias: municipiosConvertidos.promotorias,
      });
    } else {
      const indexPromotoria = municipiosDados.value[indexMunicipio].promotorias.findIndex((p) => p.nome === municipio.promotorias[0].nome);
      if (indexPromotoria === -1) {
        municipiosDados.value[indexMunicipio].promotorias.push(municipiosConvertidos.promotorias[0]);
      } else {
        municipiosDados.value[indexMunicipio].promotorias[indexPromotoria].eventos.push(municipiosConvertidos.promotorias[0].eventos[0]);
      }
    }
  }
  //console.log(municipiosDados.value);
  emit('update:municipiosDados', municipiosDados.value);
};

const editaEvento = (nomePromotoria: string, evento: { id: number; tipo: string; periodo: { start: Date; end: Date }; titulo: string; promotor_designado_evento: string }) => {
  municipiosDados.value.forEach((municipio) => {
    municipio.promotorias.forEach((promotoria) => {
      if (promotoria.nome === nomePromotoria) {
        promotoria.eventos = promotoria.eventos.map((e) => {
          if (e.id === evento.id) {
            return {
              id: evento.id,
              tipo: evento.tipo,
              periodo: [format(evento.periodo.start, 'dd/MM/yyyy'), format(evento.periodo.end, 'dd/MM/yyyy')],
              titulo: evento.titulo,
              promotor_designado_evento: evento.promotor_designado_evento,
            };
          }
          return e;
        });
      }
    });
  });

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

const convertMunicipios = (municipio: GrupoPromotoria) => {
  const municipiosConvertidos = municipio.promotorias.map((promotoria) => {
    const eventosConvertidos = promotoria.eventos.map((evento) => {
      return {
        id: evento.id,
        tipo: evento.tipo,
        periodo: [format(evento.periodo[0], 'dd/MM/yyyy'), format(evento.periodo[1], 'dd/MM/yyyy')],
        titulo: evento.titulo,
        promotor_designado_evento: evento.promotor_designado_evento,
      };
    });

    return {
      nome: promotoria.nome,
      is_especializada: promotoria.is_especializada,
      nomePromotor: promotoria.nomePromotor,
      eventos: eventosConvertidos,
    };
  });

  return {
    nome: municipio.nome,
    promotorias: municipiosConvertidos,
  };
};
onMounted(() => {
  //console.log(props.promotorias);
  //console.log(promotoriasSantanaFiltro.value);
  promotoriasSantanaFiltro.value.forEach((promotoria) => {
    if (promotoriasSantana.value.length === 0) {
      promotoriasSantana.value.push({
        nome: promotoria.nome_grupo,
        promotorias: [
          {
            nome: promotoria.nome,
            is_especializada: promotoria.is_especializada,
            nomePromotor: promotoria.promotor.nome,
            eventos: [],
          },
        ],
      });
    } else {
      const indexNomeGrupo = promotoriasSantana.value.findIndex((m) => m.nome === promotoria.nome_grupo);
      if (indexNomeGrupo === -1) {
        promotoriasSantana.value.push({
          nome: promotoria.nome_grupo,
          promotorias: [
            {
              nome: promotoria.nome,
              is_especializada: promotoria.is_especializada,
              nomePromotor: promotoria.promotor.nome,
              eventos: [],
            },
          ],
        });
      } else {
        const indexPromotoria = promotoriasSantana.value[indexNomeGrupo].promotorias.findIndex((p) => p.nome === promotoria.nome);
        if (indexPromotoria === -1) {
          promotoriasSantana.value[indexNomeGrupo].promotorias.push({
            nome: promotoria.nome,
            is_especializada: promotoria.is_especializada,
            nomePromotor: promotoria.promotor.nome,
            eventos: [],
          });
        }
      }
    }
  });
  promotoriasInterior.value.forEach((promotoria) => {
    if (municipiosInterior.value.length === 0) {
      municipiosInterior.value.push({
        nome: promotoria.nome_grupo,
        promotorias: [
          {
            nome: promotoria.nome,
            is_especializada: promotoria.is_especializada,
            nomePromotor: promotoria.promotor.nome,
            eventos: [],
          },
        ],
      });
    } else {
      const indexNomeGrupo = municipiosInterior.value.findIndex((m) => m.nome === promotoria.nome_grupo);
      if (indexNomeGrupo === -1) {
        municipiosInterior.value.push({
          nome: promotoria.nome_grupo,
          promotorias: [
            {
              nome: promotoria.nome,
              is_especializada: promotoria.is_especializada,
              nomePromotor: promotoria.promotor.nome,
              eventos: [],
            },
          ],
        });
      } else {
        const indexPromotoria = municipiosInterior.value[indexNomeGrupo].promotorias.findIndex((p) => p.nome === promotoria.nome);
        if (indexPromotoria === -1) {
          municipiosInterior.value[indexNomeGrupo].promotorias.push({
            nome: promotoria.nome,
            is_especializada: promotoria.is_especializada,
            nomePromotor: promotoria.promotor.nome,
            eventos: [],
          });
        }
      }
    }
  });
  //console.log(promotoriasSantana.value);
  //console.log(props.promotorias);
  //console.log(municipiosInterior.value);
  //console.log(promotoriasSantana.value);
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
        /> -->
        <EntranciaFinalSantanaEditor
          :promotoriasSantana="promotoriasSantana"
          @update:adicionaDados="adicionaMunicipiosDados"
          @delete:deleteEvento="deleteEventoInterior"
          @update:editaEvento="editaEvento"
        />
        <EntranciaInicialEditor
          :municipiosInterior="municipiosInterior"
          @update:adicionaMunicipiosDados="adicionaMunicipiosDados"
          @delete:deleteEventoInterior="deleteEventoInterior"
          @update:editaEvento="editaEvento"
        />
      </CardContent>
    </div>
  </Card>
</template>