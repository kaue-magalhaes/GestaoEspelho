<script setup lang="ts">
import {Promotores} from "@/Interfaces/Promotor/Promotores";
import {GrupoPromotorias} from "@/Interfaces/GrupoPromotoria/GrupoPromotorias";

import {Head} from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import BreadcrumbComponent from "@/Components/BreadcrumbComponent.vue";
import {CardDescription, CardTitle} from "@/Components/ui/card";
import {Separator} from "@/Components/ui/separator";
import PromotoriaCreateForm from "@/Components/Forms/PromotoriaCreateForm.vue";

defineProps({
    promotores: {
        type: Object as () => Promotores,
        required: true,
    },
    grupoPromotorias: {
        type: Object as () => GrupoPromotorias,
        required: true,
    }
});
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
                        <PromotoriaCreateForm
                            :promotores="promotores"
                            :grupoPromotorias="grupoPromotorias.data"
                        />
                    </CardContent>a
                </Card>
            </AdminLayout>
        </ContainerComponent>
    </AuthenticatedLayout>
</template>
