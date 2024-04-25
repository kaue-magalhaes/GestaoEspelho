<script setup lang="ts">
defineProps({
    value: {
        type: (Array as unknown) as any[],
        required: true
    }
});
</script>

<template>
    <h1 v-for="item in value" :key="item.id">
        {{ item }}
    </h1>
</template>
