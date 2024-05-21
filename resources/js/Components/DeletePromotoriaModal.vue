<script setup lang="ts">
import {Trash} from "lucide-vue-next";
import {Button} from "@/Components/ui/button";
import {usePromotoriaStore} from "@/stores/promotoria";
import {Promotoria} from "@/Interfaces/Promotoria/Promotoria";

defineProps({
    promotoria: {
        type: Object as () => Promotoria,
        required: true
    },
});
const promotoriaStore = usePromotoriaStore();
</script>

<template>
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
                <AlertDialogAction
                    variant="destructive"
                    @click="promotoriaStore.deletePromotoria(promotoria.id)"
                >
                    Deletar
                </AlertDialogAction>
            </AlertDialogFooter>
        </AlertDialogContent>
    </AlertDialog>
</template>
