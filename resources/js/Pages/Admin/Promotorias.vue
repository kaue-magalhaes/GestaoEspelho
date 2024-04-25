<script setup lang="ts">
import {Head} from "@inertiajs/vue3";
import { usePromotoriaStore } from '@/Stores/promotoria';
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {onBeforeMount, onMounted} from "vue";

const { promotorias, getPromotorias } = usePromotoriaStore();

onBeforeMount(() => {
    getPromotorias();
});

onMounted(() => {
    console.log(promotorias.value);
});
</script>

<template>
    <Head title="Espelho"/>
    <AuthenticatedLayout>
        <ContainerComponent>
            <AdminLayout>
                <Card>
                    <CardHeader>
                        <CardTitle>
                            Promotorias
                        </CardTitle>
                        <CardDescription>
                            Aqui você pode gerenciar as promotorias do sistema.
                        </CardDescription>
                    </CardHeader>
                    <CardContent>
                        <TableComponent :value="promotorias" />
                    </CardContent>
                    <CardFooter>

                    </CardFooter>
                </Card>
            </AdminLayout>
        </ContainerComponent>
    </AuthenticatedLayout>
</template>
