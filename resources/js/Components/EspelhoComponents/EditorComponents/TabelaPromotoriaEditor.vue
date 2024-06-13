<script setup lang="ts">
import EditarEventoBotao from '@/Components/EspelhoComponents/EditarEventoBotao.vue';
import AdicionarEventoBotao from '@/Components/EspelhoComponents/AdicionarEventoBotao.vue';

import {Trash} from 'lucide-vue-next';
import {Evento} from "@/Interfaces/Evento/Evento";
import {Promotor} from "@/Interfaces/Promotor/Promotor";
import {GrupoPromotoria} from "@/Interfaces/GrupoPromotoria/GrupoPromotoria";

const emit = defineEmits([
    'update:novoEventoAdicionado',
    'update:umEventoFoiAlterado',
    'delete:umEventoFoiDeletado',
]);

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

const adicionaEvento = (grupoDePromotoriaID: String, promotoriaID: String, novoEvento: Evento) => {
    emit('update:novoEventoAdicionado', grupoDePromotoriaID, promotoriaID, novoEvento);
};

const editaEvento = (grupoDePromotoriaID: String, promotoriaID: String, eventoAlterado: Evento) => {
    emit('update:umEventoFoiAlterado', grupoDePromotoriaID, promotoriaID, eventoAlterado);
};

const deleteEvento = (eventoDeletado: Evento) => {
    emit('delete:umEventoFoiDeletado', eventoDeletado);
};
</script>

<template>
    <div class="w-full" v-for="comarca in grupoPromotorias" :key="comarca.id">
        <table class="w-full text-black" v-if="comarca.promotorias && comarca.promotorias?.length > 0">
            <tbody class="text-center">
            <tr class="text-black uppercase bg-gray-300 border border-gray-400 text-center text-base">
                <th class="w-1/3 px-6 py-4 border border-gray-400" v-if="comarca.promotorias && comarca.promotorias?.length > 1">
                    {{ comarca.nome }}
                </th>
                <th class="w-1/3 px-6 py-4 border border-gray-400" rowspan="2" v-else-if="comarca.promotorias && comarca.promotorias?.length === 1">
                    {{ comarca.nome }}
                </th>
                <th class="w-1/3 px-6 py-4 border border-gray-400">
                    Promotor
                </th>
                <th class="w-1/3 px-6 py-4 border border-gray-400">
                    Periodo
                </th>
            </tr>
            <tr class="bg-white" v-for="promotoria in comarca.promotorias" :key="promotoria.id">
                <td class="border px-6 py-4 font-medium" v-if="comarca.promotorias && comarca.promotorias?.length > 1">
                    {{ promotoria.nome }}
                </td>
                <td class="border px-6 py-4 font-medium">
                    {{ promotoria.promotor?.nome }}
                </td>
                <td class="border px-6 py-4">
                    <span v-for="evento in promotoria.promotor?.eventos" :key="evento.id">
                      <span class="flex items-center justify-between space-y-2">
                        <span v-if="evento.titulo && evento.titulo !== ''">
                          {{ evento.tipo }} - {{ evento.titulo }}
                        </span>
                        <span v-else>
                          {{ evento.tipo }}
                        </span>
                        <span class="flex space-x-2">
                          <EditarEventoBotao
                              :promotores="promotores"
                              :grupoPromotoria="comarca"
                              :promotoria="promotoria"
                              :evento="evento"
                              @update:editaEvento="editaEvento"
                          />
                          <AlertDialog>
                            <AlertDialogTrigger>
                              <Button variant="destructive" size="icon">
                                <Trash class="w-4 h-4"/>
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
                                <AlertDialogAction @click="deleteEvento(evento)">
                                  Excluir evento
                                </AlertDialogAction>
                              </AlertDialogFooter>
                            </AlertDialogContent>
                          </AlertDialog>
                        </span>
                      </span>
                    </span>
                    <AdicionarEventoBotao
                        :promotores="promotores"
                        :grupoPromotoria="comarca"
                        :promotoria="promotoria"
                        :promotorTitular="promotoria.promotor"
                        @update:adicionaEvento="adicionaEvento"
                    />
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>
