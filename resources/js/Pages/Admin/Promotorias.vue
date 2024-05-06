<script setup lang="ts">
import {Head} from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {PromotoriasPaginate} from "@/Interfaces/Promotoria/PromotoriaPaginate";
import PromotoriaCardHeader from "@/Components/PromotoriaCardHeader.vue";
import PromotoriaCardContent from "@/Components/PromotoriaCardContent.vue";
import BreadcrumbComponent from "@/Components/BreadcrumbComponent.vue";

defineProps({
    promotorias: {
        type: Object as () => PromotoriasPaginate,
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
                    {label: 'Promotorias', routeName: 'admin.promotorias'}
                ]"/>
                <Card v-if="promotorias">
                    <CardHeader>
                        <PromotoriaCardHeader :promotorias="promotorias"/>
                    </CardHeader>
                    <CardContent>
                        <PromotoriaCardContent :promotorias="promotorias"/>
                    </CardContent>
                </Card>
            </AdminLayout>
        </ContainerComponent>
    </AuthenticatedLayout>
</template>
