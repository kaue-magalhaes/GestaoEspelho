<script setup lang="ts">
import {Head} from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";

</script>

<template>
    <Head title="Espelho"/>
    <AuthenticatedLayout>
        <ContainerComponent>
            <AdminLayout>
                <Card>
                    <CardHeader>
                        <CardTitle>titulo</CardTitle>
                        <CardDescription>
                            descrição
                        </CardDescription>
                    </CardHeader>
                    <CardContent>
                        Conteúdo
                    </CardContent>
                    <CardFooter>

                    </CardFooter>
                </Card>
            </AdminLayout>
        </ContainerComponent>
    </AuthenticatedLayout>
</template>
