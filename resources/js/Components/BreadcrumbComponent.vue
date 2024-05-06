<script setup lang="ts">
import {
    Breadcrumb,
    BreadcrumbItem,
    BreadcrumbLink,
    BreadcrumbList,
    BreadcrumbSeparator
} from "@/Components/ui/breadcrumb";

interface BreadcrumbItem {
    label: string;
    routeName?: string;
}

defineProps({
    items: {
        type: Array as () => BreadcrumbItem[],
        required: true
    }
});
</script>

<template>
    <Breadcrumb>
        <BreadcrumbList>
            <template v-for="(item, index) in items" :key="index">
                <BreadcrumbItem>
                    <BreadcrumbLink :href="item.routeName ? route(item.routeName) : null">
                        {{ item.label }}
                    </BreadcrumbLink>
                </BreadcrumbItem>
                <BreadcrumbSeparator v-if="index !== items.length - 1"/>
            </template>
        </BreadcrumbList>
    </Breadcrumb>
</template>
