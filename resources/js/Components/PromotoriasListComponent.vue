<script setup lang="ts">
import {Promotoria} from "@/Interfaces/Promotoria/Promotoria";
import {format} from "date-fns"
import {Check, X} from 'lucide-vue-next'
import {TableCell, TableHead} from "@/Components/ui/table";
import EditPromotoriaModal from "@/Components/EditPromotoriaModal.vue";
import DeletePromotoriaModal from "@/Components/DeletePromotoriaModal.vue";


defineEmits([
    'invertOrderByCreatedAt'
]);

defineProps({
    promotorias: {
        type: Array as () => Promotoria[],
        required: true
    }
});
</script>

<template>
    <Table>
        <TableHeader>
            <TableRow>
                <TableHead>
                    Promotoria
                </TableHead>
                <TableHead>
                    Promotor Titular
                </TableHead>
                <TableHead>
                    Especializada
                </TableHead>
                <TableHead>
                    Data de criação
                </TableHead>
                <TableHead>
                </TableHead>
            </TableRow>
        </TableHeader>
        <TableBody>
            <TableRow v-for="promotoria in promotorias" :key="promotoria.id">
                <TableCell class="font-medium">
                    {{ promotoria.nome }}
                </TableCell>
                <TableCell>
                    {{ promotoria.promotor?.nome }}
                </TableCell>
                <TableCell>
                    <Check class="w-4 h-4 text-green-500 mx-auto" v-if="promotoria.is_especializada"/>
                    <X class="w-4 h-4 text-red-500 mx-auto" v-else/>
                </TableCell>
                <TableCell>
                    {{ format(new Date(promotoria.created_at), 'dd/MM/yyyy') }} às
                    {{ format(new Date(promotoria.created_at), 'HH:mm') }} horas
                </TableCell>
                <TableCell class="flex space-x-2">
                    <EditPromotoriaModal :promotoria="promotoria"/>
                    <DeletePromotoriaModal :promotoria="promotoria"/>
                </TableCell>
            </TableRow>
        </TableBody>
    </Table>
</template>
