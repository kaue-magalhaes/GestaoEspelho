<script setup lang="ts">

import PromotoriasListComponent from "@/Components/PromotoriasListComponent.vue";
import PaginationComponent from "@/Components/PaginationComponent.vue";
import {PromotoriasPaginate} from "@/Interfaces/Promotoria/PromotoriaPaginate";

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
</template>
