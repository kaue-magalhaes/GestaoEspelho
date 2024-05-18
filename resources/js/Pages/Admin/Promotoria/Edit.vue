<script setup lang="ts">
import {Promotores} from "@/Interfaces/Promotor/Promotores";
import {Promotoria} from "@/Interfaces/Promotoria/Promotoria";

import {Head} from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import BreadcrumbComponent from "@/Components/BreadcrumbComponent.vue";
import {CardDescription, CardTitle} from "@/Components/ui/card";
import PromotoriaEditForm from "@/Components/Forms/PromotoriaEditForm.vue";
import {Separator} from "@/Components/ui/separator";

defineProps({
    promotores: {
        type: Object as () => Promotores,
        required: true,
    },
    promotoria: {
        type: Object as () => Promotoria,
        required: true
    }
});
</script>

<template>
    <Head title="Espelho"/>
    <AuthenticatedLayout>
        <ContainerComponent>
            <AdminLayout>
                <BreadcrumbComponent :items="[
                    {label: 'Home', routeName: 'admin.dashboard'},
                    {label: 'Promotorias', routeName: 'admin.promotorias'},
                    {label: 'Editar'}
                ]"/>
                <Card>
                    <CardHeader>
                        <CardTitle>
                            Editar Promotoria
                        </CardTitle>
                        <CardDescription>
                            Edite os dados da promotoria '{{ promotoria.nome }}'
                        </CardDescription>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <Separator/>
                        <PromotoriaEditForm
                            :promotores="promotores"
                            :promotoria="promotoria"
                        />
                    </CardContent>
                </Card>
            </AdminLayout>
        </ContainerComponent>
    </AuthenticatedLayout>
</template>
