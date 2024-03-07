<script setup lang="ts">
import { GrupoPromotoria, Promotor } from '@/types';
import {format} from "date-fns";
import {usePage} from "@inertiajs/vue3";
import { onMounted, ref } from 'vue';

const page = usePage();
const props = defineProps({
  grupoPromotorias: {
    type: Array as () => GrupoPromotoria[],
    required: true,
  },
});

const promotores = ref<Promotor[]>(page.props.promotores || []);

function stringToDate(dateString: string) {
  const [year, month, day] = dateString.split('-').map(Number);
  return new Date(year, month - 1, day);
}

onMounted(() => {
  //console.log(props.grupoPromotorias.filter((grupo) => grupo.eventos.length > 0));
});

</script>

<template>
  <div class="w-full" v-for="comarca in grupoPromotorias" :key="comarca.nome_grupo_promotorias">
    <table class="w-full text-black" v-if="comarca.promotorias.length > 1">
      <tbody class="text-center">
        <tr class="text-black uppercase bg-gray-300 border border-gray-400 text-center text-base">
          <th class="w-1/3 px-6 py-4 border border-gray-400">
            {{ comarca.nome_grupo_promotorias }}
          </th>
          <th class="w-1/3 px-6 py-4 border border-gray-400">
            Promotor
          </th>
          <th class="w-1/3 px-6 py-4 border border-gray-400">
            Periodo
          </th>
        </tr>
        <tr class="bg-white hover:bg-gray-50" v-for="promotoria in comarca.promotorias" :key="promotoria.nome">
          <td class="border px-6 py-4 font-medium">
            {{ promotoria.nome }}
          </td>
          <td class="border px-6 py-4 font-medium">
            {{ promotores.find((promotor) => promotor.id === promotoria.promotor_titular_id)?.nome }}
          </td>
          <td class="border px-6 py-4">
            <span v-if="comarca.eventos.filter((evento) => evento.promotor_titular_id === promotoria.promotor_titular_id).length === 0">
              <p class="text-center">
                Sem eventos
              </p>
            </span>
            <span v-else>
              <span class="flex flex-col space-y-2" v-for="evento_da_promotoria in comarca.eventos.filter((evento) => evento.promotor_titular_id === promotoria.promotor_titular_id)" :key="evento_da_promotoria.tipo">
                <span v-if="evento_da_promotoria.titulo !== ''">
                  {{ evento_da_promotoria.tipo }} - {{ evento_da_promotoria.titulo }}
                </span>
                <span v-else>
                  {{ evento_da_promotoria.tipo }}
                </span>
                <span>
                  {{ format(stringToDate(evento_da_promotoria.periodo_inicio), 'dd/MM/yyyy') }} - {{ format(stringToDate(evento_da_promotoria.periodo_fim), 'dd/MM/yyyy') }}
                </span>
                <span>
                  Promotor designado: {{ promotores.find((promotor) => promotor.id === evento_da_promotoria.promotor_designado_id)?.nome }}
                </span>
              </span>
            </span>
          </td>
        </tr>
      </tbody>
    </table>
  
    <table class="w-full text-black" v-else-if="comarca.promotorias.length === 1">
      <tbody class="text-center">
        <tr class="text-black uppercase bg-gray-300 border-gray-400 border text-center text-base">
          <th class="w-1/3 px-6 py-4 border border-gray-400" rowspan="2">
            {{ comarca.nome_grupo_promotorias }}
          </th>
          <th class="w-1/3 px-6 py-4 border border-gray-400">
            Promotor
          </th>
          <th class="w-1/3 px-6 py-4 border border-gray-400">
            Periodo
          </th>
        </tr>
        <tr class="bg-white hover:bg-gray-50" v-for="promotoria in comarca.promotorias" :key="promotoria.nome">
          <td class="border px-6 py-4 font-medium">
              {{ promotores.find((promotor) => promotor.id === promotoria.promotor_titular_id)?.nome }}
          </td>
          <td class="border px-6 py-4">
            <span v-if="comarca.eventos.filter((evento) => evento.promotor_titular_id === promotoria.promotor_titular_id).length === 0">
              <p class="text-center">
                Sem eventos
              </p>
            </span>
            <span v-else>
              <span class="flex flex-col space-y-2" v-for="evento_da_promotoria in comarca.eventos.filter((evento) => evento.promotor_titular_id === promotoria.promotor_titular_id)" :key="evento_da_promotoria.tipo">
                <span v-if="evento_da_promotoria.titulo !== ''">
                  {{ evento_da_promotoria.tipo }} - {{ evento_da_promotoria.titulo }}
                </span>
                <span v-else>
                  {{ evento_da_promotoria.tipo }}
                </span>
                <span>
                  {{ format(stringToDate(evento_da_promotoria.periodo_inicio), 'dd/MM/yyyy') }} - {{ format(stringToDate(evento_da_promotoria.periodo_fim), 'dd/MM/yyyy') }}
                </span>
                <span>
                  Promotor designado: {{ promotores.find((promotor) => promotor.id === evento_da_promotoria.promotor_designado_id)?.nome }}
                </span>
              </span>
            </span>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>