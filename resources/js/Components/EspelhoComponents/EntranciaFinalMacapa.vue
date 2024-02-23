<script setup lang="ts">
import { Promotor, Promotoria } from '@/types';
import { ref, onMounted } from 'vue';

import { Button } from '@/Components/ui/button';
import { Label } from '@/Components/ui/label';
import { Input } from '@/Components/ui/input';
import { Card } from '@/Components/ui/card';
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue} from '@/Components/ui/select'
import { Dialog, DialogContent, DialogTrigger, DialogHeader, DialogTitle, DialogDescription } from '@/Components/ui/dialog';
import DatePicker from '@/Components/DatePicker.vue';
import PlataoCaraterUrgenciaMacapa from '@/Components/EspelhoComponents/PlantaoCaraterUrgenciaMacapa.vue';

const emit = defineEmits([
  'update:promotorUrgencia',
  'update:periodoUrgencia',
  'remove:promotorUrgenciaItem',
]);

const props = defineProps({
  promotores: {
    type: Object as () => { all: Promotor[]; },
    required: true,
  },
  promotorias: {
    type: Object as () => { all: Promotoria; },
    required: true,
  },
});

const eventos = [
  { id: 1, nome: 'Férias', selecionado: false },
  { id: 2, nome: 'Licença', selecionado: false },
  { id: 3, nome: 'Plantão', selecionado: false },
  { id: 4, nome: 'Reunião', selecionado: true },
  { id: 5, nome: 'Outros', selecionado: false },
];

const updatePromotorUrgencia = (index: number, value: string) => {
  emit('update:promotorUrgencia', index, value);
};

const updatePeriodoUrgencia = (index: number, value: Date) => {
  emit('update:periodoUrgencia', index, value);
};

const removePromotorUrgenciaItem = (index: number) => {
  emit('remove:promotorUrgenciaItem', index);
};
</script>

<template>
  <div class="grid grid-cols-2 gap-4">
    <PlataoCaraterUrgenciaMacapa 
      :promotores="promotores"
      @update:promotor-urgencia="updatePromotorUrgencia"
      @update:periodo-urgencia="updatePeriodoUrgencia"
      @remove:promotor-urgencia-item="removePromotorUrgenciaItem"
    />
    <div class="col-span-2 max-w-5xl w-full flex flex-col items-center space-y-4">
      <!-- Tabela das Procuradorias de Justiça de Entrância Final - Macapá -->
      <table class="w-full text-black">
        <thead class="text-xs text-black uppercase bg-gray-300 border-x border-t">
          <tr class="text-center text-base">
            <th class="px-6 py-4">
              PROMOTORIAS DE MACAPÁ
            </th>
            <th class="px-6 py-3">
              Promotor(a)
            </th>
            <th class="px-6 py-3">
              Período
            </th>
          </tr>
        </thead>
        <tbody class="text-start">
          <tr class="bg-white hover:bg-gray-50 border" v-for="promotoria in promotorias" :key="promotoria.id">
            <th class="px-6 py-4 font-medium whitespace-nowrap">
              <div class="flex flex-col items-center">
                <h1 class="font-bold text-gray-900 dark:text-gray-200">
                  {{ promotoria.nome }}
                </h1>
              </div>
            </th>
            <td class="px-6 py-4">
              <h1 class="font-bold text-gray-900 dark:text-gray-200">
                {{ promotoria.promotor }}
              </h1>
            </td>
            <td class="px-6 py-4">
              <Dialog>
                <DialogTrigger as-child>
                  <Button variant="link">
                    Adicionar Evento
                  </Button>
                </DialogTrigger>
                <DialogContent class="w-full max-w-2xl">
                  <DialogHeader>
                    <DialogTitle>
                      Adicionar Evento
                    </DialogTitle>
                    <DialogDescription>
                      Adicione um evento para o Promotor de Justiça {{ promotoria.promotor.nome }}.
                    </DialogDescription>
                  </DialogHeader>
                  <div class="flex flex-col space-y-4">
                    <div class="flex items-center space-x-4">
                      <div class="w-1/2">
                        <Label class="text-base whitespace-nowrap">
                          Tipo do Evento:
                        </Label>
                        <Select class="mb-2 w-full">
                          <SelectTrigger>
                            <SelectValue placeholder="Selecione o tipo de evento" />
                          </SelectTrigger>
                          <SelectContent>
                            <SelectGroup>
                              <SelectLabel>Eventos</SelectLabel>
                              <SelectItem v-for="evento in eventos" :key="evento.id" :value="evento.nome">
                                {{ evento.nome }}
                              </SelectItem>
                            </SelectGroup>
                          </SelectContent>
                        </Select>
                      </div>
                      <div class="w-1/2">
                        <Label class="text-base">
                          Período:
                        </Label>
                        <!-- datepicker -->
                      </div>
                    </div>
                    <div class="flex items-center space-x-4">
                      <div class="w-1/2">
                        <Label class="text-base">
                          Título do Evento:
                        </Label>
                        <Input type="text" placeholder="Digite o título do evento" />
                      </div>
                      <div class="w-1/2">
                        <Label class="text-base whitespace-nowrap">
                          Promotor designado:
                        </Label>
                        <Select class="mb-2 w-full">
                          <SelectTrigger>
                            <SelectValue placeholder="Selecione o Promotor que foi designado" />
                          </SelectTrigger>
                          <SelectContent>
                            <SelectGroup>
                              <SelectLabel>Promotores</SelectLabel>
                              <SelectItem v-for="promotor in props.promotores.all" :key="promotor.id" :value="promotor.nome">
                                {{ promotor.nome }}
                              </SelectItem>
                            </SelectGroup>
                          </SelectContent>
                        </Select>
                      </div>
                    </div>
                    
                  </div>
                </DialogContent>
              </Dialog>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>