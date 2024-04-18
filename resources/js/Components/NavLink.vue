<script setup lang="ts">
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps<{
    dark?: boolean;
    href: string;
    active?: boolean;
}>();

const classes = computed(() =>
    props.active
        ? ('inline-flex items-center px-1 pt-1 border-b-2 border-white text-sm font-medium leading-5 focus:outline-none focus:border-MPAP-dark-blue transition duration-150 ease-in-out' + (props.dark ? ' text-white' : ' text-gray-900'))
        : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 hover:border-gray-300 focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out'  + (props.dark ? ' text-gray-400 hover:text-gray-300 focus:text-gray-300' : ' text-gray-500 hover:text-gray-700 focus:text-gray-700')
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
