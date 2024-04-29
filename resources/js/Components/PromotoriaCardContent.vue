<script setup lang="ts">

import PromotoriasListComponent from "@/Components/PromotoriasListComponent.vue";
import {Skeleton} from "@/Components/ui/skeleton";
import PaginationComponent from "@/Components/PaginationComponent.vue";
import {PromotoriasPaginate} from "@/Interfaces/Promotoria/PromotoriaPaginate";
import PromotoriaTableSkeleton from "@/Components/PromotoriaTableSkeleton.vue";

defineProps({
    promotorias: {
        type: Object as () => PromotoriasPaginate,
    }
})
</script>

<template>
    <div v-if="promotorias">
        <PromotoriasListComponent
            :promotorias="promotorias.data"
        />
        <PaginationComponent
            v-if="promotorias.total > promotorias.per_page"
            :total="promotorias.total"
            :perPage="promotorias.per_page"
            :currentPage="promotorias.current_page"
            :firstPageUrl="promotorias.first_page_url"
            :prevPageUrl="promotorias.prev_page_url"
            :nextPageUrl="promotorias.next_page_url"
            :lastPageUrl="promotorias.last_page_url"
            :links="promotorias.links"
        />
    </div>
    <div v-else>
        <PromotoriaTableSkeleton />
    </div>
</template>
