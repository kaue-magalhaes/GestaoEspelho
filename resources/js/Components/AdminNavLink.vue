<script setup lang="ts">
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps<{
    href: string;
    active?: boolean;
}>();

const classes = computed(() =>
    props.active
        ? 'font-semibold text-primary border-l border-primary pl-2'
        : 'transition-all delay-50 duration-100 ease-in-out pl-0 hover:pl-2 hover:border-l hover:border-gray-400 focus:pl-2 focus:border-l focus:border-gray-400'
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
