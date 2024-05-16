<script setup lang="ts">
import {Head} from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import BreadcrumbComponent from "@/Components/BreadcrumbComponent.vue";
import {CardDescription, CardTitle} from "@/Components/ui/card";
import {Separator} from "@/Components/ui/separator";
import PromotoriaCreateForm from "@/Components/Forms/PromotoriaCreateForm.vue";
</script>

<template>
    <Head title="Adicionar Promotoria"/>
    <AuthenticatedLayout>
        <ContainerComponent>
            <AdminLayout>
                <BreadcrumbComponent :items="[
                    {label: 'Home', routeName: 'admin.dashboard'},
                    {label: 'Promotorias', routeName: 'admin.promotorias'},
                    {label: 'Adicionar'}
                ]"/>
                <Card>
                    <CardHeader>
                        <CardTitle>
                            Adicionar Nova Promotoria
                        </CardTitle>
                        <CardDescription>
                            Preencha os dados da nova promotoria
                        </CardDescription>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <Separator/>
                        <PromotoriaCreateForm />
                    </CardContent>
                </Card>
            </AdminLayout>
        </ContainerComponent>
    </AuthenticatedLayout>
</template>
