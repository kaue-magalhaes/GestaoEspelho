<script setup lang="ts">
import {format} from 'date-fns';
import {Head, Link, useForm} from '@inertiajs/vue3';
import {EspelhosPaginate} from "@/Interfaces/EspelhosPaginate";
import PaginationComponent from "@/Components/PaginationComponent.vue";
import EspelhosListComponent from "@/Components/EspelhosListComponent.vue";
import { Search, Trash2 } from 'lucide-vue-next'
import {ref} from "vue";

const props = defineProps({
    espelhos: {
        type: Object as () => EspelhosPaginate,
        required: true
    },
    search: Object as () => {
        search: string
    }
});

const espelhosData = ref(props.espelhos.data);

const form = useForm({
    search: props.search?.search || ''
});

function searchData() {
    form.get(route('espelho.history'));
}

const periodFilter = (period: any) => {
    espelhosData.value = props.espelhos.data.filter((espelho: any) => {
        const createdAt = new Date(espelho.created_at);
        return createdAt >= period.start && createdAt <= period.end;
    });
}

const convertInSearchParams = (obj: any) => {
    const params = new URLSearchParams();
    for (const key in obj) {
        if (obj[key]) {
            params.append(key, obj[key]);
        }
    }
    return params.toString();
}

function stringToDate(dateString: string) {
    const [year, month, day] = dateString.split('-').map(Number);
    return new Date(year, month - 1, day);
}
</script>

<template>
    <Head title="Histórico"/>
    <AuthenticatedLayout>
        <ContainerComponent>
            <Card>
                <CardHeader>
                    <CardTitle>Histórico</CardTitle>
                    <CardDescription>Aqui você pode ver o histórico dos Espelhos Publicados.</CardDescription>
                    <div v-if="props.espelhos.data.length > 0" class="flex justify-between w-full items-center mt-2">
                        <div class="flex items-center space-x-2">
                            <div class="relative w-[300px]">
                                <form @submit.prevent="searchData">
                                    <Input
                                        v-model="form.search"
                                        type="text"
                                        placeholder="Buscar por título..."
                                        class="pl-8"
                                    />
                                    <span class="absolute start-0 inset-y-0 flex items-center justify-center px-2">
                                      <Search class="w-4 h-4 text-muted-foreground" />
                                    </span>
                                </form>
                            </div>
                            <div>
                                <Button
                                    type="button"
                                    @click="searchData"
                                >
                                    Buscar
                                </Button>
                            </div>
                            <div v-if="props.search?.search">
                                <Button
                                    variant="destructive"
                                    type="button"
                                    as-child
                                >
                                    <Link :href="route('espelho.history')">
                                        Limpar Busca
                                        <Trash2 class="ml-2 w-4 h-4" />
                                    </Link>
                                </Button>
                            </div>
                        </div>
                        <div>
                            <DatePicker
                                :range="true"
                                placeholder="Pesquisar por Período"
                                @update:period="periodFilter($event)"
                            />
                        </div>
                    </div>
                </CardHeader>
                <CardContent>
                    <div v-if="espelhosData.length > 0">
                        <EspelhosListComponent
                            :espelhos="espelhosData"
                        />
                        <PaginationComponent
                            v-if="props.espelhos.total > props.espelhos.per_page"
                            :total="props.espelhos.total"
                            :perPage="props.espelhos.per_page"
                            :currentPage="props.espelhos.current_page"
                            :firstPageUrl="props.espelhos.first_page_url"
                            :prevPageUrl="props.espelhos.prev_page_url"
                            :nextPageUrl="props.espelhos.next_page_url"
                            :lastPageUrl="props.espelhos.last_page_url"
                            :links="props.espelhos.links"
                            :filters="convertInSearchParams(props.search).toString()"
                        />
                    </div>
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
