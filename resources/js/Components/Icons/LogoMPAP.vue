<script setup lang="ts">

defineProps({
    dark: {
        type: Boolean,
        default: false,
    }
});
</script>

<template>
    <img
        v-if="dark"
        alt="MPAP Logo"
        src="https://uranojud.mpap.mp.br/build/assets/logo-mpap2-b54a86f8.png"
    >
    <img
        v-else
        alt="MPAP Logo"
        src="https://www.mpap.mp.br/templates/portal/images/logo-mpap.png"
    >
</template>
