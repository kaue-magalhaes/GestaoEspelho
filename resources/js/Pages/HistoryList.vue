<script setup lang="ts">
import { format } from 'date-fns';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
  espelhos: Array,
});

const form = useForm({
  initial_date: '',
  final_date: '',
});

function stringToDate(dateString: string) {
  const [year, month, day] = dateString.split('-').map(Number);
  return new Date(year, month - 1, day);
}

function dateSearch(period: any) {
  form.initial_date = format(new Date(period.start), 'yyyy-MM-dd');
  form.final_date = format(new Date(period.end), 'yyyy-MM-dd');

  form.get(route('espelho.history'), {
    initial_date: form.initial_date,
    final_date: form.final_date,
  });
}
</script>

<template>
  <Head title="Histórico" />
  <AuthenticatedLayout>
    <ContainerComponent>
      <Card>
        <CardHeader>
          <div class="flex justify-between items-center">
            <div>
              <CardTitle>Histórico</CardTitle>
              <CardDescription>Aqui você pode ver o histórico dos Espelhos Publicados.</CardDescription>
            </div>
            <div>
              <DatePicker
                :range="true"
                placeholder="Pesquisar por Data"
                @update:period="dateSearch($event)"
              />
            </div>
          </div>
        </CardHeader>
        <CardContent>
          <Table v-if="espelhos.length > 0">
            <TableHeader>
              <TableRow>
                <TableHead>
                  Espelho
                </TableHead>
                <TableHead>
                  Data de Publicação
                </TableHead>
                <TableHead>
                  Publicado por
                </TableHead>
                <TableHead class="w-[100px]">
                
                </TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              <TableRow v-for="espelho in espelhos" :key="espelho.id">
                <TableCell class="font-medium">
                  Espelho de {{ format(new Date(stringToDate(espelho.periodo_inicio)), 'dd/MM/yyyy') }} a {{ format(new Date(stringToDate(espelho.periodo_fim)), 'dd/MM/yyyy') }}
                </TableCell>
                <TableCell>
                  {{ format(new Date(espelho.created_at), 'dd/MM/yyyy') }} às {{ format(new Date(espelho.created_at), 'HH:mm') }} horas
                </TableCell>
                <TableCell>
                  {{ espelho.user.name }}
                </TableCell>
                <TableCell>
                  <a :href="`/espelho/historico/${espelho.id}`">
                    <Button size="sm" variant="link">
                      Visualizar
                    </Button>
                  </a>
                </TableCell>
              </TableRow>
            </TableBody>
          </Table>
          <div v-else>
            <div class="p-8">
              <div class="text-center">
                <h1 class="text-2xl font-semibold">
                  Nenhum Espelho Publicado
                </h1>
              </div>
              <div class="mt-4 text-center">
                <p class="mt-2 text-gray-500">
                  Ainda não há nenhum Espelho Publicado.
                </p>
              </div>
            </div>
          </div>
        </CardContent>
      </Card>
    </ContainerComponent>
  </AuthenticatedLayout>
</template>