<script setup lang="ts">
import {Promotoria, GrupoPromotoria, AtendimentoUrgencia} from '@/types';
import { ref, onBeforeMount, computed } from 'vue';

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
  'update:atendimentosUrgenciaDados',
  'update:promotoriasDados',
]);

const props = defineProps({
  promotorias: {
    type: Array as () => Promotoria[],
    required: true,
  },
});

const promotoriasMacapaFiltro = computed(() => {
  return props.promotorias.filter((promotoria) => promotoria.municipio === 'Macapá');
});
const promotoriasSantanaFiltro = computed(() => {
    return props.promotorias.filter((promotoria) => promotoria.municipio === 'Santana');
  });
const promotoriasInterior = computed(() => {
  return props.promotorias.filter((promotoria) => promotoria.municipio !== 'Macapá' && promotoria.municipio !== 'Santana');
});

const periodoEspelho = ref({
  isChanged: false,
  start: new Date(),
  end: new Date(),
});
const promotoriasDados = ref<GrupoPromotoria[]>([]);
const promotoriasMacapa = ref<GrupoPromotoria[]>([]);
const promotoriasSantana = ref<GrupoPromotoria[]>([]);
const municipiosInterior = ref<GrupoPromotoria[]>([]);
const atendimentosUrgenciaDados = ref<AtendimentoUrgencia[]>([]);

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

const adicionaPromotoriasDados = (municipio: GrupoPromotoria) => {
  //console.log(promotoriasDados.value);
  const municipiosConvertidos = convertMunicipios(municipio);

  if (promotoriasDados.value.length === 0) {
    promotoriasDados.value.push({
      nome: municipiosConvertidos.nome,
      promotorias: municipiosConvertidos.promotorias,
    }); 
  } else {
    const indexMunicipio = promotoriasDados.value.findIndex((m) => m.nome === municipio.nome);
    if (indexMunicipio === -1) {
      promotoriasDados.value.push({
        nome: municipiosConvertidos.nome,
        promotorias: municipiosConvertidos.promotorias,
      });
    } else {
      const indexPromotoria = promotoriasDados.value[indexMunicipio].promotorias.findIndex((p) => p.nome === municipio.promotorias[0].nome);
      if (indexPromotoria === -1) {
        promotoriasDados.value[indexMunicipio].promotorias.push(municipiosConvertidos.promotorias[0]);
      } else {
        promotoriasDados.value[indexMunicipio].promotorias[indexPromotoria].eventos.push(municipiosConvertidos.promotorias[0].eventos[0]);
      }
    }
  }
  //console.log(promotoriasDados.value);
  emit('update:promotoriasDados', promotoriasDados.value);
};

const editaEvento = (nomePromotoria: string, evento: { id: number; tipo: string; periodo: { start: Date; end: Date }; titulo: string; promotor_designado_evento: string }) => {
  promotoriasDados.value.forEach((municipio) => {
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

  emit('update:promotoriasDados', promotoriasDados.value);
};

const deleteEventoInterior = (eventoId: number, nomePromotoria: string) => {
  promotoriasDados.value.forEach((municipio) => {
    municipio.promotorias.forEach((promotoria) => {
      if (promotoria.nome === nomePromotoria) {
        promotoria.eventos = promotoria.eventos.filter((evento) => evento.id !== eventoId);
      }
      if (promotoria.eventos.length === 0) {
        municipio.promotorias = municipio.promotorias.filter((p) => p.nome !== promotoria.nome);
      }
    });
    if (municipio.promotorias.length === 0) {
      promotoriasDados.value = promotoriasDados.value.filter((m) => m.nome !== municipio.nome);
    }
  });

  emit('update:promotoriasDados', promotoriasDados.value)
};

const updateAtendimentosUrgenciaArray = (value: AtendimentoUrgencia) => {
  //console.log(atendimentosUrgenciaDados.value);
  if (atendimentosUrgenciaDados.value.length === 0) {
    atendimentosUrgenciaDados.value.push(value);
  } else {
    if (atendimentosUrgenciaDados.value[value.id]) {
      if (atendimentosUrgenciaDados.value[value.id].nome_promotor === '') {
        atendimentosUrgenciaDados.value[value.id].nome_promotor = value.nome_promotor;
      } else if (atendimentosUrgenciaDados.value[value.id].periodo.length === 0) {
        atendimentosUrgenciaDados.value[value.id].periodo = value.periodo;
      }
    } else {
      atendimentosUrgenciaDados.value.push(value);
    }
  }
  emit('update:atendimentosUrgenciaDados', atendimentosUrgenciaDados.value);
};

const removeAtendimentoUrgencia = (index: number) => {
  atendimentosUrgenciaDados.value.splice(index, 1);
  emit('update:atendimentosUrgenciaDados', atendimentosUrgenciaDados.value);
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
      municipio: promotoria.municipio,
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
onBeforeMount(() => {
  //console.log(props.promotorias);
  //console.log(promotoriasSantanaFiltro.value);
  promotoriasMacapaFiltro.value.forEach((promotoria) => {
    if (promotoriasMacapa.value.length === 0) {
      promotoriasMacapa.value.push({
        nome: promotoria.nome_grupo,
        promotorias: [
          {
            nome: promotoria.nome,
            municipio: promotoria.municipio,
            is_especializada: promotoria.is_especializada,
            nomePromotor: promotoria.promotor.nome,
            eventos: [],
          },
        ],
      });
    } else {
      const indexNomeGrupo = promotoriasMacapa.value.findIndex((m) => m.nome === promotoria.nome_grupo);
      if (indexNomeGrupo === -1) {
        promotoriasMacapa.value.push({
          nome: promotoria.nome_grupo,
          promotorias: [
            {
              nome: promotoria.nome,
              municipio: promotoria.municipio,
              is_especializada: promotoria.is_especializada,
              nomePromotor: promotoria.promotor.nome,
              eventos: [],
            },
          ],
        });
      } else {
        const indexPromotoria = promotoriasMacapa.value[indexNomeGrupo].promotorias.findIndex((p) => p.nome === promotoria.nome);
        if (indexPromotoria === -1) {
          promotoriasMacapa.value[indexNomeGrupo].promotorias.push({
            nome: promotoria.nome,
            municipio: promotoria.municipio,
            is_especializada: promotoria.is_especializada,
            nomePromotor: promotoria.promotor.nome,
            eventos: [],
          });
        }
      }
    }
  });
  promotoriasSantanaFiltro.value.forEach((promotoria) => {
    if (promotoriasSantana.value.length === 0) {
      promotoriasSantana.value.push({
        nome: promotoria.nome_grupo,
        promotorias: [
          {
            nome: promotoria.nome,
            municipio: promotoria.municipio,
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
              municipio: promotoria.municipio,
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
            municipio: promotoria.municipio,
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
            municipio: promotoria.municipio,
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
              municipio: promotoria.municipio,
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
            municipio: promotoria.municipio,
            is_especializada: promotoria.is_especializada,
            nomePromotor: promotoria.promotor.nome,
            eventos: [],
          });
        }
      }
    }
  });
  //console.log(props.promotorias);
  //console.log(promotoriasSantana.value);
  //console.log(municipiosInterior.value);
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
        <EntranciaFinalMacapaEditor
          :promotorias="promotoriasMacapa"
          @update:atendimentosUrgencia="updateAtendimentosUrgenciaArray"
          @delete:atendimentosUrgencia="removeAtendimentoUrgencia"
          @update:adicionaDados="adicionaPromotoriasDados"
          @delete:deleteEvento="deleteEventoInterior"
          @update:editaEvento="editaEvento"
        />
        <EntranciaFinalSantanaEditor
          :promotorias="promotoriasSantana"
          @update:adicionaDados="adicionaPromotoriasDados"
          @delete:deleteEvento="deleteEventoInterior"
          @update:editaEvento="editaEvento"
        />
        <EntranciaInicialEditor
          :municipiosInterior="municipiosInterior"
          @update:adicionaDados="adicionaPromotoriasDados"
          @delete:deleteEventoInterior="deleteEventoInterior"
          @update:editaEvento="editaEvento"
        />
      </CardContent>
    </div>
  </Card>
</template>