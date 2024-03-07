<script setup lang="ts">
import {Evento, GrupoPromotoria, Promotor, Promotoria} from '@/types';
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

const page = usePage();
const emit = defineEmits([
  'update:novoEventoAdicionado',
  'update:UmEventoFoiAlterado',
  'delete:umEventoFoiDeletado',
  'update:grupoPromotorias',
]);

const props = defineProps({
  promotorias: Array as () => Promotoria[],
});

const promotores = ref<Promotor[]>(page.props.promotores || []);
const eventos = ref<Evento[]>(page.props.eventos || []);
const grupoPromotorias = ref<GrupoPromotoria[]>([]);

const adicionaEvento = (nomeDoGrupoDePromotorias: String, novoEvento: Evento) => {
  grupoPromotorias.value.forEach((grupoPromotoria) => {
    if (grupoPromotoria.nome_grupo_promotorias === nomeDoGrupoDePromotorias) {
      grupoPromotoria.eventos.push(novoEvento);
    }
  });
  emit('update:novoEventoAdicionado', nomeDoGrupoDePromotorias, novoEvento);
};

const EditaEvento = (eventoAlterado: Evento) => {
  grupoPromotorias.value.forEach((grupoPromotoria) => {
    grupoPromotoria.eventos.forEach((evento) => {
      if (evento.id === eventoAlterado.id) {
        evento.id = eventoAlterado.id;
        evento.tipo = eventoAlterado.tipo;
        evento.periodo_inicio = eventoAlterado.periodo_inicio;
        evento.periodo_fim = eventoAlterado.periodo_fim;
        evento.titulo = eventoAlterado.titulo;
        evento.promotor_designado_id = eventoAlterado.promotor_designado_id;
      }
    });
  });
  emit('update:UmEventoFoiAlterado', eventoAlterado);
};

const deleteEvento = (eventoId: string) => {
  grupoPromotorias.value.forEach((grupoPromotoria) => {
    grupoPromotoria.eventos = grupoPromotoria.eventos.filter((evento) => evento.id !== eventoId);
  });
  emit('delete:umEventoFoiDeletado', eventoId);
};

onMounted(() => {
  props.promotorias?.forEach((promotoria) => {
    if (grupoPromotorias.value.length === 0) {
      grupoPromotorias.value.push({
        nome_grupo_promotorias: promotoria.nome_grupo_promotorias,
        promotorias: [{
          id: promotoria.id,
          nome: promotoria.nome,
          nome_grupo_promotorias: promotoria.nome_grupo_promotorias,
          municipio: promotoria.municipio,
          is_especializada: promotoria.is_especializada,
          espelho_id: promotoria.espelho_id,
          promotor_titular_id: promotoria.promotor_titular_id,
          created_at: promotoria.created_at,
          updated_at: promotoria.updated_at,
        }],
        eventos: eventos.value.filter((evento) => evento.promotor_titular_id === promotoria.promotor_titular_id) || [],
      });
    } else {
      const grupoPromotoria = grupoPromotorias.value.find((grupoPromotoria) => grupoPromotoria.nome_grupo_promotorias === promotoria.nome_grupo_promotorias);
      if (grupoPromotoria) {
        grupoPromotoria.promotorias.push({
          id: promotoria.id,
          nome: promotoria.nome,
          nome_grupo_promotorias: promotoria.nome_grupo_promotorias,
          municipio: promotoria.municipio,
          is_especializada: promotoria.is_especializada,
          espelho_id: promotoria.espelho_id,
          promotor_titular_id: promotoria.promotor_titular_id,
          created_at: promotoria.created_at,
          updated_at: promotoria.updated_at,
        });
        grupoPromotoria.eventos = eventos.value.filter((evento) => evento.promotor_titular_id === promotoria.promotor_titular_id) || [];
      } else {
        grupoPromotorias.value.push({
          nome_grupo_promotorias: promotoria.nome_grupo_promotorias,
          promotorias: [{
            id: promotoria.id,
            nome: promotoria.nome,
            nome_grupo_promotorias: promotoria.nome_grupo_promotorias,
            municipio: promotoria.municipio,
            is_especializada: promotoria.is_especializada,
            espelho_id: promotoria.espelho_id,
            promotor_titular_id: promotoria.promotor_titular_id,
            created_at: promotoria.created_at,
            updated_at: promotoria.updated_at,
          }],
          eventos: eventos.value.filter((evento) => evento.promotor_titular_id === promotoria.promotor_titular_id) || [],
        });
      }
    }
  });
  emit('update:grupoPromotorias', grupoPromotorias.value);
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
        <tr class="bg-white" v-for="promotoria in comarca.promotorias" :key="promotoria.id">
          <td class="border px-6 py-4 font-medium">
            {{ promotoria.nome }}
          </td>
          <td class="border px-6 py-4 font-medium">
            {{ promotores.find((promotor) => promotor.id === promotoria.promotor_titular_id)?.nome }}
          </td>
          <td class="border px-6 py-4">
            <span v-for="evento_da_promotoria in comarca.eventos.filter((evento) => evento.promotor_titular_id === promotoria.promotor_titular_id)" :key="evento_da_promotoria.id">
              <span class="flex items-center justify-between space-y-2">
                <span v-if="evento_da_promotoria.titulo !== ''">
                  {{ evento_da_promotoria.tipo }} - {{ evento_da_promotoria.titulo }}
                </span>
                <span v-else>
                  {{ evento_da_promotoria.tipo }}
                </span>
                <span class="flex space-x-2">
                  <EditarEventoBotao
                    :promotores="promotores"
                    :nomePromotoria="promotoria.nome"
                    :nomeComarca="comarca.nome_grupo_promotorias"
                    :nomePromotor="promotores.find((promotor) => promotor.id === promotoria.promotor_titular_id)?.nome || ''"
                    :id = "evento_da_promotoria.id"
                    :tipo="evento_da_promotoria.tipo"
                    :periodo_inicio="evento_da_promotoria.periodo_inicio"
                    :periodo_fim="evento_da_promotoria.periodo_fim"
                    :titulo="evento_da_promotoria.titulo"
                    :promotor_designado_evento="promotores.find((promotor) => promotor.id === evento_da_promotoria.promotor_designado_id)?.nome"
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
                          <span v-if="evento_da_promotoria.titulo !== ''">
                            Tem certeza que deseja excluir o evento "{{ evento_da_promotoria.tipo }} - {{ evento_da_promotoria.titulo }}"?
                          </span>
                          <span v-else>
                            Tem certeza que deseja excluir o evento "{{ evento_da_promotoria.tipo }}"?
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
                        <AlertDialogAction @click="deleteEvento(evento_da_promotoria.id)">
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
              :nomeMunicipio="comarca.nome_grupo_promotorias"
              :nomePromotoria="promotoria.nome"
              :nomePromotor="promotores.find((promotor) => promotor.id === promotoria.promotor_titular_id)?.nome || ''"
              @update:adicionaEvento="adicionaEvento"
            />
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
        <tr class="bg-white" v-for="promotoria in comarca.promotorias" :key="promotoria.nome">
          <td class="border px-6 py-4 font-medium">
            {{ promotores.find((promotor) => promotor.id === promotoria.promotor_titular_id)?.nome }}
          </td>
          <td class="border px-6 py-4">
            <span v-for="evento_da_promotoria in comarca.eventos.filter((evento) => evento.promotor_titular_id === promotoria.promotor_titular_id)" :key="evento_da_promotoria.id">
              <span class="flex items-center justify-between space-y-2">
                <span v-if="evento_da_promotoria.titulo !== ''">
                  {{ evento_da_promotoria.tipo }} - {{ evento_da_promotoria.titulo }}
                </span>
                <span v-else>
                  {{ evento_da_promotoria.tipo }}
                </span>
                <span class="flex space-x-2">
                  <EditarEventoBotao
                    :promotores="promotores"
                    :nomePromotoria="promotoria.nome"
                    :nomeComarca="comarca.nome_grupo_promotorias"
                    :nomePromotor="promotores.find((promotor) => promotor.id === promotoria.promotor_titular_id)?.nome || ''"
                    :id = "evento_da_promotoria.id"
                    :tipo="evento_da_promotoria.tipo"
                    :periodo_inicio="evento_da_promotoria.periodo_inicio"
                    :periodo_fim="evento_da_promotoria.periodo_fim"
                    :titulo="evento_da_promotoria.titulo"
                    :promotor_designado_evento="promotores.find((promotor) => promotor.id === evento_da_promotoria.promotor_designado_id)?.nome"
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
                          <span v-if="evento_da_promotoria.titulo !== ''">
                            Tem certeza que deseja excluir o evento "{{ evento_da_promotoria.tipo }} - {{ evento_da_promotoria.titulo }}"?
                          </span>
                          <span v-else>
                            Tem certeza que deseja excluir o evento "{{ evento_da_promotoria.tipo }}"?
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
                        <AlertDialogAction @click="deleteEvento(evento_da_promotoria.id)">
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
              :nomePromotoria="promotoria.nome"
              :nomeMunicipio="comarca.nome_grupo_promotorias"
              :nomePromotor="promotores.find((promotor) => promotor.id === promotoria.promotor_titular_id)?.nome || ''"
              @update:adicionaEvento="adicionaEvento"
            />
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
