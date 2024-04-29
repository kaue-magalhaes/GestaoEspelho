<script setup lang="ts">
import {Head} from "@inertiajs/vue3";
//import { usePromotoriaStore } from '@/Stores/promotoria';
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {onBeforeMount, ref} from "vue";
import {PromotoriasPaginate} from "@/Interfaces/Promotoria/PromotoriaPaginate";
import PromotoriaCardHeader from "@/Components/PromotoriaCardHeader.vue";
import PromotoriaCardContent from "@/Components/PromotoriaCardContent.vue";

const props = defineProps({
    promotorias: {
        type: Object as () => PromotoriasPaginate,
        required: true
    }
});

//const { getPromotorias } = usePromotoriaStore();

const promotorias = ref<PromotoriasPaginate>(props.promotorias);

onBeforeMount(() => {
    // getPromotorias().then(result => {
    //     promotorias.value = result;
    // });
});
</script>

<template>
    <Head title="Espelho"/>
    <AuthenticatedLayout>
        <ContainerComponent>
            <AdminLayout>
                <Card>
                    <CardHeader>
                        <PromotoriaCardHeader :promotorias="promotorias" />
                    </CardHeader>
                    <CardContent>
                        <PromotoriaCardContent :promotorias="promotorias" />
                    </CardContent>
                </Card>
            </AdminLayout>
        </ContainerComponent>
    </AuthenticatedLayout>
</template>
