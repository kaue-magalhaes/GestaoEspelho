<script setup lang="ts">
import { Promotoria } from '@/types';
import { onMounted, ref } from 'vue';
import { usePage } from '@inertiajs/vue3';

import Button from '@/Components/ui/button/Button.vue';
import AdicionarEventoBotao from '@/Components/EspelhoComponents/AdicionarEventoBotao.vue';

import { format } from 'date-fns';
import { Edit, Trash } from 'lucide-vue-next';

type Evento = {
  tipo: string;
  periodo:{
    start: Date | null;
    end: Date | null;
  };
  titulo: string;
  promotorDesignado: string;
};

type Municipios = {
  nome: string;
  promotorias: {
    nome: string;
    nomePromotor: string;
    eventos: {
      tipo: string;
      periodo: string[];
      titulo: string;
      promotorDesignado: string;
    }[];
  }[];
};

const promotores = usePage().props.promotores;

const emit = defineEmits([
  'update:adicionaEvento',
  'delete:deleteEvento',
]);

const props = defineProps({
  municipios: {
    type: Array as () => Municipios[],
    required: true,
  },
});

const municipiosReativos = ref<Municipios[]>(props.municipios);

const evento = ref<Evento>({
  tipo: '',
  periodo:{
      start: null,
      end: null,
  },
  titulo: '',
  promotorDesignado: '',
});

const adicionaEvento = (nomePromotoria: String, nomeMunicipio: String, eventoSelelcionado: Evento) => {
  //console.log(nomePromotoria);
  //console.log(nomeMunicipio);
  //console.log(eventoSelelcionado);
  
  const municipioSelecionado = municipiosReativos.value.find((municipio) => municipio.nome === nomeMunicipio);
  const promotoriaId = municipioSelecionado?.promotorias.findIndex((promotoria) => promotoria.nome === nomePromotoria);

  //console.log(promotoriaId);

  evento.value = eventoSelelcionado;
  
  municipiosReativos.value.forEach((municipio) => {
    municipio.promotorias.forEach((promotoria) => {
      if (promotoria.nome === nomePromotoria) {
        if (eventoSelelcionado.periodo.start && eventoSelelcionado.periodo.end) {
          promotoria.eventos.push({
            tipo: evento.value.tipo,
            periodo: [format(eventoSelelcionado.periodo.start, 'dd/MM/yyyy'), format(eventoSelelcionado.periodo.end, 'dd/MM/yyyy')],
            titulo: evento.value.titulo,
            promotorDesignado: evento.value.promotorDesignado,
          });
        }
      }
    });
  });

  emit('update:adicionaEvento', promotoriaId, municipioSelecionado, evento.value);
};

const deleteEvento = (promotoria_id: number) => {
  //emit('delete:deleteEvento', promotoria_id);
  //const index = eventos.value.findIndex((evento) => evento.promotoria_id === promotoria_id);

  //eventos.value.splice(index, 1);
};

onMounted(() => {
  //console.log(promotores);
  //console.log(props.municipios);
  
});
</script>

<template>
  <div class="w-full" v-for="municipio in municipiosReativos" :key="municipio.nome">
    <table class="w-full text-black" v-if="municipio.promotorias.length > 1">
      <tbody class="text-center">
        <tr class="text-black uppercase bg-gray-300 border border-gray-400 text-center text-base">
          <th class="w-1/3 px-6 py-4 border border-gray-400">
            {{ municipio.nome }}
          </th>
          <th class="w-1/3 px-6 py-4 border border-gray-400">
            Promotor
          </th>
          <th class="w-1/3 px-6 py-4 border border-gray-400">
            Periodo
          </th>
        </tr>
        <tr class="bg-white" v-for="dadosPromotoria in municipio.promotorias" :key="dadosPromotoria.nome">
          <td class="border px-6 py-4 font-medium">
            {{ dadosPromotoria.nome }}
          </td>
          <td class="border px-6 py-4 font-medium">
            {{ dadosPromotoria.nomePromotor }}
          </td>
          <td class="border px-6 py-4">
            <span v-for="evento in dadosPromotoria.eventos" :key="evento.tipo">
              <div class="flex items-center justify-between">
                <div v-if="evento.titulo !== ''">
                  {{ evento.tipo }} - {{ evento.titulo }}
                </div>
                <div v-else>
                  {{ evento.tipo }}
                </div>
                <div class="flex space-x-2">
                  <Button variant="outline" size="icon">
                    <Edit class="w-4 h-4" />
                  </Button>
                  <Button variant="destructive" size="icon" @click="deleteEvento">
                    <Trash class="w-4 h-4" />
                  </Button>
                </div>
              </div>
            </span>
            <AdicionarEventoBotao
              :promotores="promotores"
              :nomeMunicipio="municipio.nome"
              :nomePromotoria="dadosPromotoria.nome"
              :nomePromotor="dadosPromotoria.nomePromotor"
              @update:adicionaEvento="adicionaEvento"
            />
          </td>
        </tr>
      </tbody>
    </table>
  
    <table class="w-full text-black" v-else-if="municipio.promotorias.length === 1">
      <tbody class="text-center">
        <tr class="text-black uppercase bg-gray-300 border-gray-400 border text-center text-base">
          <th class="w-1/3 px-6 py-4 border border-gray-400" rowspan="2">
            {{ municipio.nome }}
          </th>
          <th class="w-1/3 px-6 py-4 border border-gray-400">
            Promotor
          </th>
          <th class="w-1/3 px-6 py-4 border border-gray-400">
            Periodo
          </th>
        </tr>
        <tr class="bg-white" v-for="dadosPromotoria in municipio.promotorias" :key="dadosPromotoria.nome">
          <td class="border px-6 py-4 font-medium">
            {{ dadosPromotoria.nomePromotor }}
          </td>
          <td class="border px-6 py-4">
            <span v-for="evento in dadosPromotoria.eventos" :key="evento.tipo">
              <div class="flex items-center justify-between space-y-2">
                <div v-if="evento.titulo !== ''">
                  {{ evento.tipo }} - {{ evento.titulo }}
                </div>
                <div v-else>
                  {{ evento.tipo }}
                </div>
                <div class="flex space-x-2">
                  <Button variant="outline" size="icon">
                    <Edit class="w-4 h-4" />
                  </Button>
                  <Button variant="destructive" size="icon" @click="deleteEvento">
                    <Trash class="w-4 h-4" />
                  </Button>
                </div>
              </div>
            </span>
            <AdicionarEventoBotao
              :promotores="promotores"
              :nomePromotoria="dadosPromotoria.nome"
              :nomeMunicipio="municipio.nome"
              :nomePromotor="dadosPromotoria.nomePromotor"
              @update:adicionaEvento="adicionaEvento"
            />
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>