<script setup>
import { ref, defineEmits, watch } from 'vue';
import { Button } from '@/Components/ui/button';
import { Label } from '@/Components/ui/label';
import { Input } from '@/Components/ui/input';
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue} from '@/Components/ui/select'
import { Card, CardContent, CardHeader, CardTitle } from '@/Components/ui/card';
import { Dialog, DialogContent, DialogTrigger, DialogHeader, DialogTitle, DialogDescription, DialogFooter } from '@/Components/ui/dialog';
import Calendar from 'primevue/calendar';
import { format } from 'date-fns';
import { Plus, Trash2 } from 'lucide-vue-next';

const periodoEspelho = ref(null);
const urgenciaInputComponent = ref([]);

const eventos = [
  { id: 1, nome: 'Férias', selecionado: false },
  { id: 2, nome: 'Licença', selecionado: false },
  { id: 3, nome: 'Plantão', selecionado: false },
  { id: 4, nome: 'Reunião', selecionado: true },
  { id: 5, nome: 'Outros', selecionado: false },
];

const emit = defineEmits([
  'update:periodoEspelho',
  'update:promotorUrgencia',
  'update:periodoUrgencia',
  'remove:promotorUrgenciaItem',
]);

const adicionarInput = () => {
  urgenciaInputComponent.value.push({ 
    value: {
      promotorUrgencia: '',
      periodoUrgencia: '',
    }
  });
};

const removeInput = (index) => {
  urgenciaInputComponent.value.splice(index, 1);
  emit('remove:promotorUrgenciaItem', index);
};

const dateFormat = (date) => {
  return format(date, 'dd/MM/yyyy');
};

watch(periodoEspelho, (value) => {
  if (value[0] === null || value[1] === null) return [null, null];
  const dataInicio = value[0];
  const dataFinal = value[1];

  const dataInicioFormatada = dateFormat(dataInicio);
  const dataFinalFormatada = dateFormat(dataFinal);

  emit('update:periodoEspelho', [dataInicioFormatada, dataFinalFormatada]);
});
</script>

<template>
  <Card>
    <div class="max-w-5xl mx-auto">
      <CardHeader class="flex flex-row justify-between">
        <CardTitle class="font-semibold">
          Espelho do Ministério Público
        </CardTitle>
        <span class="flex items-end">
          <Label for="period" class="text-base mr-4">
            Período:
          </Label>
          <Calendar
            selectionMode="range"
            dateFormat="dd/mm/yy"
            inputId="period"
            showIcon
            placeholder="Selecione o período"
            v-model=periodoEspelho
            class="text-sm"
          />
        </span>
      </CardHeader>
  
      <CardContent>
        <div class="mt-8 flex flex-col space-y-4">
          <div class="grid grid-cols-2 gap-4">
            <div class="col-span-2 text-center text-xl font-bold text-gray-700 dark:text-gray-200 mb-2">
              PROMOTORIAS DE JUSTIÇA DE ENTRÂNCIA FINAL – MACAPÁ
            </div>
            <Card class="col-span-2 flex flex-col py-4 items-center space-y-2 w-full">
              <Label class="text-xl">
                Plantão de Atendimentos em Caráter de Urgência - Macapá:
              </Label>
              <div v-for="(input, index) in urgenciaInputComponent" :key="index" class="w-full px-4 flex justify-center items-center space-x-4">
                <div class="flex flex-row items-center w-full space-x-4">
                  <Label class="text-base whitespace-nowrap">
                    Nome do Promotor:
                  </Label>
                  <Select v-model="input.value.promotorUrgencia" class="mb-2 w-full">
                    <SelectTrigger>
                      <SelectValue placeholder="Selecione o promotor" />
                    </SelectTrigger>
                    <SelectContent>
                      <SelectGroup>
                        <SelectLabel>Promotores</SelectLabel>
                        <SelectItem v-for="promotor in $page.props.promotores.all" :key="promotor.id" :value="promotor.nome" @click="emit('update:promotorUrgencia', index, promotor.nome)">
                          {{ promotor.nome }}
                        </SelectItem>
                      </SelectGroup>
                    </SelectContent>
                  </Select>
                </div>
                <div class="flex flex-row items-center w-full space-x-4">
                  <Label class="text-base">
                    Período:
                  </Label>
                  <Calendar
                    dateFormat="dd/mm/yy"
                    showIcon
                    placeholder="Selecione o período"
                    v-model=input.value.periodoUrgencia
                    @update:modelValue="emit('update:periodoUrgencia', index, dateFormat(input.value.periodoUrgencia))"
                  />
                </div>
                <div class="flex mb-2">
                  <Button @click="removeInput(index)" variant="destructive" class="p-3">
                    <Trash2 class="w-5 h-5 text-white" />
                  </Button>
                </div>
              </div>
              <Button variant="ghost" class="w-1/4" @click="adicionarInput">
                Adicionar <Plus class="ml-1 w-4 h-4" />
              </Button>
            </Card>
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
                  <tr class="bg-white hover:bg-gray-50 border" v-for="promotoria in $page.props.promotorias.all" :key="promotoria.id">
                    <th class="px-6 py-4 font-medium whitespace-nowrap">
                      <div class="flex flex-col items-center">
                        <h1 class="font-bold text-gray-900 dark:text-gray-200">
                          {{ promotoria.nome }}
                        </h1>
                      </div>
                    </th>
                    <td class="px-6 py-4">
                      <h1 class="font-bold text-gray-900 dark:text-gray-200">
                        {{ promotoria.promotor.nome }}
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
                                <Calendar
                                  selectionMode="range"
                                  dateFormat="dd/mm/yy"
                                  showIcon
                                  placeholder="Selecione o período"
                                  inputClass="w-full placeholder-black h-10 py-2 px-3 border placeholder-opacity-50"
                                />
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
                                      <SelectItem v-for="promotor in $page.props.promotores.all" :key="promotor.id" :value="promotor.nome">
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
        </div>
      </CardContent>
    </div>
  </Card>
</template>