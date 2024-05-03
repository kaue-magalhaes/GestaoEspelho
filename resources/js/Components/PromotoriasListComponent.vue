<script setup lang="ts">
import {Promotoria} from "@/Interfaces/Promotoria/Promotoria";
import {Button} from "@/Components/ui/button";
import {format} from "date-fns"
import {Check, Trash, X} from 'lucide-vue-next'
import {TableCell, TableHead} from "@/Components/ui/table";
import {usePromotoriaStore} from "@/Stores/promotoria";
import EditPromotoriaModal from "@/Components/EditPromotoriaModal.vue";


defineEmits([
    'invertOrderByCreatedAt'
]);

defineProps({
    promotorias: {
        type: Array as () => Promotoria[],
        required: true
    }
});

const promotoriaStore = usePromotoriaStore();

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

                    <AlertDialog>
                        <AlertDialogTrigger>
                            <Button variant="destructive" size="icon">
                                <Trash class="w-4 h-4"/>
                            </Button>
                        </AlertDialogTrigger>
                        <AlertDialogContent>
                            <AlertDialogHeader>
                                <AlertDialogTitle>
                                    Deletar Promotoria
                                </AlertDialogTitle>
                                <AlertDialogDescription>
                                    Você tem certeza que deseja deletar a promotoria?
                                </AlertDialogDescription>
                            </AlertDialogHeader>
                            <AlertDialogFooter>
                                <AlertDialogCancel>
                                    Cancelar
                                </AlertDialogCancel>
                                <AlertDialogAction variant="destructive"
                                                   @click="promotoriaStore.deletePromotoria(promotoria.id)">
                                    Deletar
                                </AlertDialogAction>
                            </AlertDialogFooter>
                        </AlertDialogContent>
                    </AlertDialog>
                </TableCell>
            </TableRow>
        </TableBody>
    </Table>
</template>
