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
        ? ('block w-full ps-3 pe-4 py-2 border-l-4 border-white text-start text-base font-medium text-indigo-700 focus:outline-none focus:text-indigo-800 focus:bg-indigo-100 focus:border-indigo-700 transition duration-150 ease-in-out' + (props.dark ? ' text-white' : ' text-gray-900'))
        : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-600 hover:border-gray-300 focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out'  + (props.dark ? ' text-gray-400 hover:text-gray-300 focus:text-gray-300' : ' text-gray-500 hover:text-gray-700 focus:text-gray-700')
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
