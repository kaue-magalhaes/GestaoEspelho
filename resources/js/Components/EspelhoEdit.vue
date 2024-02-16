<script setup>
import { ref } from 'vue';
import { Button } from '@/components/ui/button';
import { Label } from '@/Components/ui/label';
import { Card, CardContent, CardHeader, CardTitle } from '@/Components/ui/card';
import Calendar from 'primevue/calendar';

const dates = ref(null);

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
            v-model=dates
            class="text-sm"
          />
        </span>
      </CardHeader>
  
      <CardContent>
        <div class="mt-8 flex flex-col space-y-4">
          <div class="grid grid-cols-2 gap-4">
            <Card class="col-span-2 flex flex-col py-4 items-center space-y-2 w-full">
              <Label class="text-xl">
                Plantão de Atendimentos em Caráter de Urgência - Macapá:
              </Label>
              <Button variant="ghost" class="w-1/4">
                Adicionar +
              </Button>
            </Card>
          </div>
        </div>
      </CardContent>
    </div>
  </Card>
</template>