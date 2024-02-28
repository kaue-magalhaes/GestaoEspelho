<script setup lang="ts">
import { onMounted } from 'vue';

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
      promotorDesignadoEvento: string;
    }[];
  }[];
};

const props = defineProps({
  municipios: {
    type: Array as () => Municipios[],
    required: true,
  },
});

onMounted(() => {
  //console.log(props.dados);
});
</script>

<template>
  <!-- percorre os dados separados por municipio -->
  <div class="w-full" v-for="municipio in municipios" :key="municipio.nome">
    <!-- se o municipio tiver mais de uma promotoria exibe dessa forma -->
    <table class="w-full text-black" v-if="municipio.promotorias.length > 1">
      <tbody class="text-center">
        <tr class="text-black uppercase bg-gray-300 border border-gray-400 text-center text-base">
          <!-- municipio string -->
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
        <!-- percorre as procuradorias -->
        <tr class="bg-white hover:bg-gray-50" v-for="dadosPromotoria in municipio.promotorias" :key="dadosPromotoria.nome">
            <!-- nome da procuradoria string -->
          <td class="border px-6 py-4 font-medium">
            {{ dadosPromotoria.nome }}
          </td>
            <!-- nome do promotor string -->
          <td class="border px-6 py-4 font-medium">
            {{ dadosPromotoria.nomePromotor }}
          </td>
          <td class="border px-6 py-4">
            <!-- eventos[] -->
            <span class="flex flex-col space-y-2" v-for="evento in dadosPromotoria.eventos" :key="evento.tipo">
              <div v-if="evento.titulo !== ''">
                {{ evento.tipo }} - {{ evento.titulo }}
              </div>
              <div v-else>
                {{ evento.tipo }}
              </div>
              <div>
                {{ evento.periodo[0] }} a {{ evento.periodo[1] }}
              </div>
              <div>
                Promotor designado: {{ evento.promotorDesignadoEvento }}
              </div>
            </span>
          </td>
        </tr>
      </tbody>
    </table>
  
    <!-- se o municipio tiver apenas uma promotoria exibe dessa forma -->
    <table class="w-full text-black" v-else-if="municipio.promotorias.length === 1">
      <tbody class="text-center">
        <tr class="text-black uppercase bg-gray-300 border-gray-400 border text-center text-base">
          <!-- municipio string -->
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
        <tr class="bg-white hover:bg-gray-50" v-for="dadosPromotoria in municipio.promotorias" :key="dadosPromotoria.nome">
          <!-- nome do promotor string -->
          <td class="border px-6 py-4 font-medium">
              {{ dadosPromotoria.nomePromotor }}
          </td>
          <td class="border px-6 py-4">
            <!-- eventos[] -->
            <span class="flex flex-col space-y-2" v-for="evento in dadosPromotoria.eventos" :key="evento.tipo">
              <div v-if="evento.titulo !== ''">
                {{ evento.tipo }} - {{ evento.titulo }}
              </div>
              <div v-else>
                {{ evento.tipo }}
              </div>
              <div>
                {{ evento.periodo[0] }} a {{ evento.periodo[1] }}
              </div>
              <div>
                Promotor designado: {{ evento.promotorDesignadoEvento }}
              </div>
            </span>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>