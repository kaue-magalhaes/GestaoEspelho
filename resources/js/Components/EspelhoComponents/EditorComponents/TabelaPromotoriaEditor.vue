<script setup lang="ts">
import { Promotoria } from '@/types';
import { onMounted, ref } from 'vue';
import { usePage } from '@inertiajs/vue3';

import Button from '@/Components/ui/button/Button.vue';
import AdicionarEventoBotao from '@/Components/EspelhoComponents/AdicionarEventoBotao.vue';

import { Edit, Trash } from 'lucide-vue-next';

const promotores = usePage().props.promotores;

const emit = defineEmits([
  'update:adicionaEvento',
  'delete:deleteEvento',
]);

const props = defineProps({
  dados: {
    type: Object as () => { [key: string]: Promotoria[] },
    required: true,
  },
});

const eventos = ref<{ promotoria_id: number; evento: { tipo: string; periodo: { start: Date; end: Date }; titulo: string; promotorDesignado: string } }[]>([]);

const adicionaEvento = (promotoriaKey: string, promotoria_id: number, evento: { tipo: string; periodo: { start: Date; end: Date }; titulo: string; promotorDesignado: string }) => {
  const unidade = props.dados[promotoriaKey].find((promotoria) => promotoria.id === promotoria_id);

  eventos.value.push({
    promotoria_id,
    evento,
  });

  emit('update:adicionaEvento', unidade, evento);
};

const deleteEvento = (promotoria_id: number) => {
  emit('delete:deleteEvento', promotoria_id);
  const index = eventos.value.findIndex((evento) => evento.promotoria_id === promotoria_id);

  eventos.value.splice(index, 1);
};

onMounted(() => {
  //console.log(promotores);
  //console.log(props.dados);
  
});
</script>

<template>
  <div class="w-full" v-for="municipioKey in Object.keys(props.dados)" :key="municipioKey">
    <table class="w-full text-black" v-if="props.dados[municipioKey].length > 1">
      <tbody class="text-center">
        <tr class="text-black uppercase bg-gray-300 border border-gray-400 text-center text-base">
          <th class="w-1/3 px-6 py-4 border border-gray-400">
            {{ props.dados[municipioKey][0].municipio }}
          </th>
          <th class="w-1/3 px-6 py-4 border border-gray-400">
            Promotor
          </th>
          <th class="w-1/3 px-6 py-4 border border-gray-400">
            Periodo
          </th>
        </tr>
        <tr class="bg-white" v-for="dadoPromotoria in props.dados[municipioKey]" :key="dadoPromotoria.id">
          <td class="border px-6 py-4 font-medium">
            {{ dadoPromotoria.nome }}
          </td>
          <td class="border px-6 py-4 font-medium">
            {{ dadoPromotoria.promotor.nome }}
          </td>
          <td class="border px-6 py-4">
            <span v-for="evento in eventos" :key="evento.promotoria_id">
              <span class="flex flex-col" v-if="evento.promotoria_id === dadoPromotoria.id">
                {{ evento.evento.tipo }} - {{ evento.evento.titulo }}
                <div class="flex items-center justify-between">
                  <div>
                    {{ evento.evento.tipo }} - {{ evento.evento.titulo }}
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
            </span>
            <AdicionarEventoBotao
              :promotoriaKey="municipioKey"
              :promotoria="dadoPromotoria"
              :promotores="promotores"
              @update:adicionaEvento="adicionaEvento"
            />
          </td>
        </tr>
      </tbody>
    </table>
  
    <table class="w-full text-black" v-else-if="props.dados[municipioKey].length === 1">
      <tbody class="text-center">
        <tr class="text-black uppercase bg-gray-300 border-gray-400 border text-center text-base">
          <th class="w-1/3 px-6 py-4 border border-gray-400" rowspan="2">
            {{ props.dados[municipioKey][0].municipio }}
          </th>
          <th class="w-1/3 px-6 py-4 border border-gray-400">
            Promotor
          </th>
          <th class="w-1/3 px-6 py-4 border border-gray-400">
            Periodo
          </th>
        </tr>
        <tr class="bg-white" v-for="dadoPromotoria in props.dados[municipioKey]" :key="dadoPromotoria.id">
          <td class="border px-6 py-4 font-medium">
            {{ dadoPromotoria.promotor.nome }}
          </td>
          <td class="border px-6 py-4 space-y-2">
            <span v-for="evento in eventos" :key="evento.promotoria_id">
              <span class="flex flex-col" v-if="evento.promotoria_id === dadoPromotoria.id">
                {{ evento.evento.tipo }} - {{ evento.evento.titulo }}
                <div class="flex items-center justify-between">
                  <div>
                    {{ evento.evento.tipo }} - {{ evento.evento.titulo }}
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
            </span>
            <AdicionarEventoBotao
              :promotoriaKey="municipioKey"
              :promotoria="dadoPromotoria"
              :promotores="promotores"
              @update:adicionaEvento="adicionaEvento"
            />
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>