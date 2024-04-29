<script setup lang="ts">

import {Skeleton} from "@/Components/ui/skeleton";
import {PromotoriasPaginate} from "@/Interfaces/Promotoria/PromotoriaPaginate";

defineProps({
    promotorias: {
        type: Object as () => PromotoriasPaginate,
    }
})
</script>

<template>
    <div v-if="promotorias" class="space-y-2">
        <CardTitle>
            Promotorias
        </CardTitle>
        <CardDescription>
            Aqui você pode gerenciar as promotorias do sistema.
        </CardDescription>
    </div>
    <div v-else class="space-y-2">
        <CardTitle>
            <Skeleton class="h-4 w-[150px]" />
        </CardTitle>
        <CardDescription>
            <Skeleton class="h-4 w-[300px]" />
        </CardDescription>
    </div>
</template>
