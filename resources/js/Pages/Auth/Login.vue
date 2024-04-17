<script setup lang="ts">
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import { Label } from '@/Components/ui/label';
import { Input } from '@/Components/ui/input';
import { Button } from '@/Components/ui/button';
import { CardDescription, CardTitle } from '@/Components/ui/card';
import { Head, useForm } from '@inertiajs/vue3';

defineProps<{
    canResetPassword?: boolean;
    status?: string;
}>();

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => {
            form.reset('password');
        },
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Login" />

        <template #card-header>
            <CardTitle>
                Gestão Espelho
            </CardTitle>
            <CardDescription>
                Faça login em sua conta com seu usuário e senha da Intranet.
            </CardDescription>
        </template>

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <Label>
                    Usuário
                </Label>

                <Input
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    placeholder="kaue.brandao"
                    required
                    autofocus
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <Label for="password">
                    Senha
                </Label>

                <Input
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    placeholder="123@Senha"
                    required
                />

                <InputError class="mt-2" :message="form.errors.password" />

<!--                <Link-->
<!--                    v-if="canResetPassword"-->
<!--                    :href="route('password.request')"-->
<!--                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md"-->
<!--                >-->
<!--                    Esqueceu sua senha?-->
<!--                </Link>-->
            </div>

            <div class="flex items-center justify-end mt-4">
                <Button
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Entrar
                </Button>
            </div>
        </form>
    </GuestLayout>
</template>
