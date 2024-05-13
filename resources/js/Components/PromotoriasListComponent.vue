<script setup lang="ts">
import {Promotoria} from "@/Interfaces/Promotoria/Promotoria";
import {Link} from '@inertiajs/vue3'
import {format} from "date-fns"
import {Check, Edit, X} from 'lucide-vue-next'
import {TableCell, TableHead} from "@/Components/ui/table";
import DeletePromotoriaModal from "@/Components/DeletePromotoriaModal.vue";
import {Button} from "@/Components/ui/button";

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
                    ID
                </TableHead>
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
            <TableRow v-for="(promotoria, index) in promotorias" :key="promotoria.id">
                <TableCell class="font-medium">
                    {{ index + 1 }}
                </TableCell>
                <TableCell>
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
                    <Link :href="route('admin.promotorias.edit', promotoria.id)">
                        <Button variant="outline" size="icon">
                            <Edit class="w-4 h-4"/>
                        </Button>
                    </Link>
                    <DeletePromotoriaModal :promotoria="promotoria"/>
                </TableCell>
            </TableRow>
        </TableBody>
    </Table>
</template>
