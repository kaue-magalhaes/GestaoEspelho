<script setup lang="ts">
import {PromotoriasPaginate} from "@/Interfaces/Promotoria/PromotoriaPaginate";
import {Button} from "@/Components/ui/button";
import {Plus} from 'lucide-vue-next'

defineProps({
    promotorias: {
        type: Object as () => PromotoriasPaginate,
    }
})

</script>

<template>
    <div v-if="promotorias" class="flex justify-between">
        <div class="space-y-2">
            <CardTitle>
                Promotorias
            </CardTitle>
            <CardDescription>
                Aqui você pode gerenciar as promotorias do sistema.
            </CardDescription>
        </div>
        <div class="flex items-end">
            <Button variant="default" size="sm">
                <span class="flex items-center gap-2">
                    <Plus class="w-4 h-4"/>
                    Adicionar Promotoria
                </span>
            </Button>
        </div>
    </div>
</template>
