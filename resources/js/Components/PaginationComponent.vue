<script setup lang="ts">
import {
    Pagination,
    PaginationEllipsis,
    PaginationFirst, PaginationLast,
    PaginationList, PaginationListItem,
    PaginationNext,
    PaginationPrev
} from "@/Components/ui/pagination";
import {Link} from "@inertiajs/vue3";
import {Button} from "@/Components/ui/button";
import {Links} from "@/Interfaces/Links";
import {build} from "vite";

defineProps({
    total: {
        type: Number,
        required: true
    },
    perPage: {
        type: Number,
        required: true
    },
    currentPage: {
        type: Number,
        required: true
    },
    firstPageUrl: {
        type: String,
        required: true
    },
    prevPageUrl: {
        type: String as () => string | null,
        required: true
    },
    nextPageUrl: {
        type: String as () => string | null,
        required: true
    },
    lastPageUrl: {
        type: String,
        required: true
    },
    links: {
        type: Array as () => Links[],
        required: true
    },
    filters: {
        type: String,
        required: false,
        default: ''
    }
});

function buildUrl(url: string, filters: string) {
    if (filters) {
        return `${url}&${filters}`;
    }

    return url;
}
</script>

<template>
    <div class="flex justify-center mt-4">
        <Pagination v-slot="{ page }" :total="total" :sibling-count="1" show-edges :default-page="currentPage" :items-per-page="perPage">
            <PaginationList v-slot="{ items }" class="flex items-center gap-1">
                <Link :href="buildUrl(firstPageUrl, filters)">
                    <PaginationFirst />
                </Link>
                <Link :href="buildUrl(prevPageUrl || firstPageUrl, filters)">
                    <PaginationPrev />
                </Link>

                <template v-for="(item, index) in items">
                    <PaginationListItem v-if="item.type === 'page'" :key="index" :value="item.value" as-child>
                        <Button class="w-10 h-10 p-0" :variant="item.value === page ? 'default' : 'outline'" as-child>
                            <Link :href="buildUrl(links[item.value].url || '#', filters)">
                                {{ item.value }}
                            </Link>
                        </Button>
                    </PaginationListItem>
                    <PaginationEllipsis v-else :key="item.type" :index="index" />
                </template>

                <Link :href="buildUrl(nextPageUrl || lastPageUrl, filters)">
                    <PaginationNext />
                </Link>
                <Link :href="buildUrl(lastPageUrl, filters)">
                    <PaginationLast />
                </Link>
            </PaginationList>
        </Pagination>
    </div>
</template>
