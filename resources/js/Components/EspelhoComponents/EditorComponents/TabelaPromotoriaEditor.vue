<script setup lang="ts">
import { onMounted, ref } from 'vue';
import { usePage } from '@inertiajs/vue3';

import Button from '@/Components/ui/button/Button.vue';
import EditarEventoBotao from '@/Components/EspelhoComponents/EditarEventoBotao.vue';
import AdicionarEventoBotao from '@/Components/EspelhoComponents/AdicionarEventoBotao.vue';
import {
  AlertDialog,
  AlertDialogAction,
  AlertDialogCancel,
  AlertDialogContent,
  AlertDialogDescription,
  AlertDialogFooter,
  AlertDialogHeader,
  AlertDialogTitle,
  AlertDialogTrigger,
} from '@/Components/ui/alert-dialog'

import { Trash } from 'lucide-vue-next';

type Evento = {
  id: number;
  tipo: string;
  periodo:{
    start: Date | null;
    end: Date | null;
  };
  titulo: string;
  promotorDesignadoEvento: string;
};

type Municipios = {
  nome: string;
  promotorias: {
    nome: string;
    nomePromotor: string;
    eventos: {
      id: number;
      tipo: string;
      periodo: Date[];
      titulo: string;
      promotorDesignadoEvento: string;
    }[];
  }[];
};

const promotores = usePage().props.promotores;

const emit = defineEmits([
  'update:adicionaEvento',
  'delete:deleteEvento',
  'update:editaEvento',
]);

/* TENHO QUE GARANTIR QUE RECEBAM UM VALOR COM O ID */
const props = defineProps({
  municipios: {
    type: Array as () => Municipios[],
    required: true,
  },
});

const municipiosReativos = ref<Municipios[]>(props.municipios);

const evento = ref<Evento>({
  id: 0,
  tipo: '',
  periodo:{
    start: null,
    end: null,
  },
  titulo: '',
  promotorDesignadoEvento: '',
});

const adicionaEvento = (nomePromotoria: String, nomeMunicipio: String, eventoSelelcionado: Evento) => {
  //console.log(nomePromotoria);
  //console.log(nomeMunicipio);
  //console.log(eventoSelelcionado);
  //console.log(eventoSelelcionado.promotorDesignadoEvento);
  const municipioSelecionado = municipiosReativos.value.find((municipio) => municipio.nome === nomeMunicipio);
  const promotoriaId = municipioSelecionado?.promotorias.findIndex((promotoria) => promotoria.nome === nomePromotoria);

  //console.log(promotoriaId);
  municipiosReativos.value.forEach((municipio) => {
    municipio.promotorias.forEach((promotoria) => {
      if (promotoria.nome === nomePromotoria) {
        evento.value = {
          id: promotoria.eventos.length,
          tipo: eventoSelelcionado.tipo,
          periodo: {
            start: eventoSelelcionado.periodo.start,
            end: eventoSelelcionado.periodo.end,
          },
          titulo: eventoSelelcionado.titulo,
          promotorDesignadoEvento: eventoSelelcionado.promotorDesignadoEvento,
        };
        if (evento.value.periodo.start && evento.value.periodo.end) {
          promotoria.eventos.push({
            id: promotoria.eventos.length,
            tipo: evento.value.tipo,
            periodo: [evento.value.periodo.start, evento.value.periodo.end],
            titulo: evento.value.titulo,
            promotorDesignadoEvento: evento.value.promotorDesignadoEvento,
          });
        }
      }
    });
  });

  //console.log(municipiosReativos.value);
  
  emit('update:adicionaEvento', promotoriaId, municipioSelecionado, evento.value);
};

const EditaEvento = (nomePromotoria: string, evento: Evento) => {
  //console.log(evento.promotorDesignadoEvento);
  
  municipiosReativos.value.forEach((municipio) => {
    municipio.promotorias.forEach((promotoria) => {
      if (promotoria.nome === nomePromotoria) {
        promotoria.eventos.forEach((eventoPromotoria) => {
          if (eventoPromotoria.id === evento.id) {
            if (evento.periodo.start && evento.periodo.end) {
              eventoPromotoria.tipo = evento.tipo;
              eventoPromotoria.periodo = [evento.periodo.start, evento.periodo.end];
              eventoPromotoria.titulo = evento.titulo;
              eventoPromotoria.promotorDesignadoEvento = evento.promotorDesignadoEvento;
            }
          }
        });
      }
    });
  });

  emit('update:editaEvento', nomePromotoria, evento);
};

const deleteEvento = (eventoId: number, nomePromotoria: string) => {
  municipiosReativos.value.forEach((municipio) => {
    municipio.promotorias.forEach((promotoria) => {
      if (promotoria.nome === nomePromotoria) {
        promotoria.eventos = promotoria.eventos.filter((evento) => evento.id !== eventoId);
      }
    });
  });
  emit('delete:deleteEvento', eventoId, nomePromotoria);
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
            <span v-for="evento in dadosPromotoria.eventos" :key="evento.id">
              <div class="flex items-center justify-between space-y-2">
                <div v-if="evento.titulo !== ''">
                  {{ evento.tipo }} - {{ evento.titulo }}
                </div>
                <div v-else>
                  {{ evento.tipo }}
                </div>
                <div class="flex space-x-2">
                  <EditarEventoBotao
                    :promotores="promotores"
                    :nomePromotoria="dadosPromotoria.nome"
                    :nomeMunicipio="municipio.nome"
                    :nomePromotor="dadosPromotoria.nomePromotor"
                    :id = "evento.id"
                    :tipo="evento.tipo"
                    :periodo="evento.periodo"
                    :titulo="evento.titulo"
                    :promotorDesignadoEvento="evento.promotorDesignadoEvento"
                    @update:editaEvento="EditaEvento"
                  />
                  <AlertDialog>
                    <AlertDialogTrigger>
                      <Button variant="destructive" size="icon">
                        <Trash class="w-4 h-4" />
                      </Button>
                    </AlertDialogTrigger>
                    <AlertDialogContent>
                      <AlertDialogHeader>
                        <AlertDialogTitle>
                          <span v-if="evento.titulo !== ''">
                            Tem certeza que deseja excluir o evento "{{ evento.tipo }} - {{ evento.titulo }}"?
                          </span>
                          <span v-else>
                            Tem certeza que deseja excluir o evento "{{ evento.tipo }}"?
                          </span>
                        </AlertDialogTitle>
                        <AlertDialogDescription>
                          Esta ação não pode ser desfeita.
                        </AlertDialogDescription>
                      </AlertDialogHeader>
                      <AlertDialogFooter>
                        <AlertDialogCancel class="bg-red-500 hover:bg-red-400 text-white hover:text-white">
                          Cancelar
                        </AlertDialogCancel>
                        <AlertDialogAction @click="deleteEvento(evento.id, dadosPromotoria.nome)">
                          Excluir evento
                        </AlertDialogAction>
                      </AlertDialogFooter>
                    </AlertDialogContent>
                  </AlertDialog>
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
            <span v-for="evento in dadosPromotoria.eventos" :key="evento.id">
              <div class="flex items-center justify-between space-y-2">
                <div v-if="evento.titulo !== ''">
                  {{ evento.tipo }} - {{ evento.titulo }}
                </div>
                <div v-else>
                  {{ evento.tipo }}
                </div>
                <div class="flex space-x-2">
                  <EditarEventoBotao
                    :promotores="promotores"
                    :nomePromotoria="dadosPromotoria.nome"
                    :nomeMunicipio="municipio.nome"
                    :nomePromotor="dadosPromotoria.nomePromotor"
                    :id = "evento.id"
                    :tipo="evento.tipo"
                    :periodo="evento.periodo"
                    :titulo="evento.titulo"
                    :promotorDesignadoEvento="evento.promotorDesignadoEvento"
                    @update:editaEvento="EditaEvento"
                  />
                  <AlertDialog>
                    <AlertDialogTrigger>
                      <Button variant="destructive" size="icon">
                        <Trash class="w-4 h-4" />
                      </Button>
                    </AlertDialogTrigger>
                    <AlertDialogContent>
                      <AlertDialogHeader>
                        <AlertDialogTitle>
                          <span v-if="evento.titulo !== ''">
                            Tem certeza que deseja excluir o evento "{{ evento.tipo }} - {{ evento.titulo }}"?
                          </span>
                          <span v-else>
                            Tem certeza que deseja excluir o evento "{{ evento.tipo }}"?
                          </span>
                        </AlertDialogTitle>
                        <AlertDialogDescription>
                          Esta ação não pode ser desfeita.
                        </AlertDialogDescription>
                      </AlertDialogHeader>
                      <AlertDialogFooter>
                        <AlertDialogCancel class="bg-red-500 hover:bg-red-400 text-white hover:text-white">
                          Cancelar
                        </AlertDialogCancel>
                        <AlertDialogAction @click="deleteEvento(evento.id, dadosPromotoria.nome)">
                          Excluir evento
                        </AlertDialogAction>
                      </AlertDialogFooter>
                    </AlertDialogContent>
                  </AlertDialog>
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