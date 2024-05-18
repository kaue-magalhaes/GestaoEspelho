<script setup lang="ts">
import AdminNavLink from "@/Components/AdminNavLink.vue";
</script>

<template>
    <main class="flex min-h-[calc(100vh_-_theme(spacing.16))] flex-1 flex-col gap-4 md:gap-8">
        <div class="mx-auto grid w-full gap-2">
            <h1 class="text-2xl font-semibold">
                Área do Administrador
            </h1>
        </div>
        <div class="mx-auto grid w-full items-start gap-6 lg:grid-cols-[130px_1fr]">
            <nav class="grid gap-4 text-sm text-muted-foreground">
                <AdminNavLink :href="route('admin.dashboard')" :active="route().current('admin.dashboard')">
                    Home
                </AdminNavLink>
                <AdminNavLink :href="route('admin.promotorias')" :active="route().current('admin.promotorias')">
                    Promotorias
                </AdminNavLink>
            </nav>
            <div class="grid gap-6">
                <slot/>
            </div>
        </div>
    </main>
</template>
