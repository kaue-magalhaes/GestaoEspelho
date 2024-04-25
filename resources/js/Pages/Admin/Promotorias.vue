<script setup lang="ts">
import {Head} from "@inertiajs/vue3";
import { usePromotoriaStore } from '@/Stores/promotoria';
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {onBeforeMount, ref} from "vue";
import { Promotoria } from "@/Interfaces/Promotoria";

const { getPromotorias } = usePromotoriaStore();

const promotorias = ref<Promotoria[]>([]);

onBeforeMount(() => {
    getPromotorias().then(result => {
        promotorias.value = result;
    });
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
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>
                                        Nome
                                    </TableHead>
                                    <TableHead>
                                        Ações
                                    </TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                <TableRow v-for="promotoria in promotorias" :key="promotoria.id">
                                    <TableCell>
                                        {{ promotoria.nome }}
                                    </TableCell>
                                    <TableCell>
                                        <Button>
                                            Editar
                                        </Button>
                                        <Button>
                                            Excluir
                                        </Button>
                                    </TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>
                    </CardContent>
                    <CardFooter>

                    </CardFooter>
                </Card>
            </AdminLayout>
        </ContainerComponent>
    </AuthenticatedLayout>
</template>
