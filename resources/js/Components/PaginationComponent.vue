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

const props = defineProps({
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
    },
    nextPageUrl: {
        type: String as () => string | null,
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
        type: Object,
        required: false,
    },
    orderAsc: {
        type: Boolean,
        default: false
    }
});

const convertInSearchParams = (obj: any) => {
    const params = new URLSearchParams();

    for (const key in obj) {
        if (obj[key]) {
            if (typeof obj[key] === 'object') {
                for (const subKey in obj[key]) {
                    params.append(`filters[${key}][${subKey}]`, obj[key][subKey] ? obj[key][subKey] : '');
                }
            } else {
                params.append(`filters[${key}]`, obj[key]);
            }
        }
    }
    return params.toString();
}

function buildUrl(url: string, filters: string) {
    if (filters) {
        return props.orderAsc ? `${url}&orderBy=asc&${filters}` : `${url}&orderBy=desc&${filters}`;
    }

    return props.orderAsc ? `${url}&orderBy=asc` : `${url}&orderBy=desc`;
}
</script>

<template>
    <div class="flex justify-center mt-4">
        <Pagination v-slot="{ page }" :total="total" :sibling-count="1" show-edges :default-page="currentPage" :items-per-page="perPage">
            <PaginationList v-slot="{ items }" class="flex items-center gap-1">
                <Link :href="buildUrl(firstPageUrl, convertInSearchParams(filters).toString())">
                    <PaginationFirst />
                </Link>
                <Link :href="buildUrl(prevPageUrl || firstPageUrl, convertInSearchParams(filters).toString())">
                    <PaginationPrev />
                </Link>

                <template v-for="(item, index) in items">
                    <PaginationListItem v-if="item.type === 'page'" :key="index" :value="item.value" as-child>
                        <Button class="w-10 h-10 p-0" :variant="item.value === page ? 'default' : 'outline'" as-child>
                            <Link :href="buildUrl(links[item.value].url || '#', convertInSearchParams(filters).toString())">
                                {{ item.value }}
                            </Link>
                        </Button>
                    </PaginationListItem>
                    <PaginationEllipsis v-else :key="item.type" :index="index" />
                </template>

                <Link :href="buildUrl(nextPageUrl || lastPageUrl, convertInSearchParams(filters).toString())">
                    <PaginationNext />
                </Link>
                <Link :href="buildUrl(lastPageUrl, convertInSearchParams(filters).toString())">
                    <PaginationLast />
                </Link>
            </PaginationList>
        </Pagination>
    </div>
</template>
