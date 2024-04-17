<script setup lang="ts">
import { Card, CardContent, CardHeader } from '@/Components/ui/card';
import LogoMPAP from '@/Components/Icons/LogoMPAP.vue';
</script>

<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-MPAP-blue space-y-10">
        <LogoMPAP
            dark
            class="w-60"
        />
        <Card class="w-full sm:max-w-md mt-6 p-6">
            <CardHeader>
                <slot name="card-header"/>
            </CardHeader>
            <CardContent>
                <slot />
            </CardContent>
        </Card>
    </div>
</template>
