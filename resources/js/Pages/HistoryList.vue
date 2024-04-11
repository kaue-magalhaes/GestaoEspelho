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
    filters: {
        type: Object as () => {
            search: string
            period: {
                start: string
                end: string
            }
        },
        default: () => ({
            search: '',
            period: {
                start: '',
                end: ''
            }
        }),
    },
    orderAsc: {
        type: Boolean,
        default: false
    }
});

const filters = ref(props.filters);
const orderAsc = ref(props.orderAsc);

const espelhosData = ref(props.espelhos.data);

const form = useForm({
    filters: filters.value
});

function search() {
    form.filters = {
        search: filters.value.search,
        period: {
            start: filters.value.period.start,
            end: filters.value.period.end
        }
    }
    form.get(route('espelho.history', {'orderBy': orderAsc.value ? 'asc' : 'desc'}));
}

function searchFilterByPeriod(period: any) {
    filters.value.period.start = format(period.start, 'yyyy-MM-dd');
    filters.value.period.end = format(period.end, 'yyyy-MM-dd');
    search()
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
                                <form @submit.prevent="search">
                                    <Input
                                        v-model="filters.search"
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
                                    @click="search"
                                >
                                    Buscar
                                </Button>
                            </div>
                            <div v-if="
                                    form.filters.search ||
                                    form.filters.period.start ||
                                    form.filters.period.end
                            ">
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
                                v-if="
                                    (
                                        !props.filters.period.start &&
                                        !props.filters.period.end
                                    )
                                "
                                :range="true"
                                placeholder="Pesquisar por Período"
                                @update:period="searchFilterByPeriod($event)"
                            />
                            <DatePicker
                                v-else
                                :range="true"
                                :was-changed="
                                    !(
                                        !props.filters.period.start &&
                                        !props.filters.period.end
                                    )
                                "
                                :period_start="stringToDate(props.filters.period.start)"
                                :period_end="stringToDate(props.filters.period.end)"
                                placeholder="Pesquisar por Período"
                                @update:period="searchFilterByPeriod($event)"
                            />
                        </div>
                    </div>
                </CardHeader>
                <CardContent>
                    <div v-if="espelhosData.length > 0">
                        <EspelhosListComponent
                            :espelhos="espelhosData"
                            @invertOrderByCreatedAt="orderAsc = !orderAsc; search()"
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
                            :filters="props.filters"
                            :orderAsc="orderAsc"
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
