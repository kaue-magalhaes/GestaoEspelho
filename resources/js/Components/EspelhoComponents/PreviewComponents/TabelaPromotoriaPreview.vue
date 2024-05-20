<script setup lang="ts">
import {format} from "date-fns";
import {Promotor} from "@/Interfaces/Promotor/Promotor";
import {GrupoPromotoria} from "@/Interfaces/GrupoPromotoria/GrupoPromotoria";

defineProps({
    promotores: {
        type: Array as () => Promotor[],
        required: true,
    },
    grupoPromotorias: {
        type: Array as () => GrupoPromotoria[],
        required: true,
    },
});

function stringToDate(dateString: string) {
    const [year, month, day] = dateString.split('-').map(Number);
    return new Date(year, month - 1, day);
}
</script>

<template>
    <div class="w-full" v-for="comarca in grupoPromotorias" :key="comarca.id">
        <table class="w-full text-black" v-if="comarca.promotorias && comarca.promotorias.length > 1">
            <tbody class="text-center">
            <tr class="text-black uppercase bg-gray-300 border border-gray-400 text-center text-base">
                <th class="w-1/3 px-6 py-4 border border-gray-400">
                    {{ comarca.nome }}
                </th>
                <th class="w-1/3 px-6 py-4 border border-gray-400">
                    Promotor
                </th>
                <th class="w-1/3 px-6 py-4 border border-gray-400">
                    Periodo
                </th>
            </tr>
            <tr class="bg-white hover:bg-gray-50" v-for="promotoria in comarca.promotorias" :key="promotoria.id">
                <td class="border px-6 py-4 font-medium">
                    {{ promotoria.nome }}
                </td>
                <td class="border px-6 py-4 font-medium">
                    {{ promotoria.promotor?.nome }}
                </td>
                <td class="border px-6 py-4">
            <span v-if="promotoria.promotor?.eventos?.length === 0">
              <span class="text-center">
                Sem eventos
              </span>
            </span>
                    <span v-else>
              <span class="flex flex-col space-y-2" v-for="evento in promotoria.promotor?.eventos" :key="evento.id">
                <span v-if="evento.titulo !== ''">
                  {{ evento.tipo }} - {{ evento.titulo }}
                </span>
                <span v-else>
                  {{ evento.tipo }}
                </span>
                <span>
                  {{
                        format(stringToDate(evento.periodo_inicio), 'dd/MM/yyyy')
                    }} - {{ format(stringToDate(evento.periodo_fim), 'dd/MM/yyyy') }}
                </span>
                <span>
                  Promotor designado: {{
                        promotores.find((promotor) => promotor.id === evento.promotor_designado_id)?.nome
                    }}
                </span>
              </span>
            </span>
                </td>
            </tr>
            </tbody>
        </table>

        <table class="w-full text-black" v-else-if="comarca.promotorias?.length === 1">
            <tbody class="text-center">
            <tr class="text-black uppercase bg-gray-300 border-gray-400 border text-center text-base">
                <th class="w-1/3 px-6 py-4 border border-gray-400" rowspan="2">
                    {{ comarca.nome }}
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
                    {{ promotoria.promotor?.nome }}
                </td>
                <td class="border px-6 py-4">
            <span v-if="promotoria.promotor?.eventos?.length === 0">
              <span class="text-center">
                Sem eventos
              </span>
            </span>
                    <span v-else>
              <span class="flex flex-col space-y-2" v-for="evento in promotoria.promotor?.eventos" :key="evento.id">
                <span v-if="evento.titulo !== ''">
                  {{ evento.tipo }} - {{ evento.titulo }}
                </span>
                <span v-else>
                  {{ evento.tipo }}
                </span>
                <span>
                  {{
                        format(stringToDate(evento.periodo_inicio), 'dd/MM/yyyy')
                    }} - {{ format(stringToDate(evento.periodo_fim), 'dd/MM/yyyy') }}
                </span>
                <span>
                  Promotor designado: {{
                        promotores.find((promotor) => promotor.id === evento.promotor_designado_id)?.nome
                    }}
                </span>
              </span>
            </span>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>
