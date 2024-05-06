<script setup lang="ts">
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import { Label } from '@/Components/ui/label';
import { Input } from '@/Components/ui/input';
import { Button } from '@/Components/ui/button';
import { CardDescription, CardTitle } from '@/Components/ui/card';
import {Tooltip, TooltipContent, TooltipProvider, TooltipTrigger} from '@/Components/ui/tooltip'
import { Head, useForm } from '@inertiajs/vue3';

defineProps<{
    status?: string;
}>();

const form = useForm({
    login_intranet: '',
    senha_intranet: '',
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => {
            form.reset('senha_intranet');
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
                    id="login"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.login_intranet"
                    placeholder="kaue.brandao"
                    required
                    autofocus
                />

                <InputError class="mt-2" :message="form.errors.login_intranet" />
            </div>

            <div class="mt-4">
                <Label for="password">
                    Senha
                </Label>

                <Input
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.senha_intranet"
                    placeholder="123@Senha"
                    required
                />

                <InputError class="mt-2" :message="form.errors.senha_intranet" />


                <TooltipProvider delay-duration="150" delay="1000" placement="top">
                    <Tooltip>
                        <TooltipTrigger>
                            <a
                                href="https://centraldeti.mpap.mp.br/projects/csti/issues/new?mascara"
                                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md"
                            >
                                Esqueceu sua senha?
                            </a>
                        </TooltipTrigger>
                        <TooltipContent>
                            <p>Criar chamado para a Central de TI</p>
                        </TooltipContent>
                    </Tooltip>
                </TooltipProvider>
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
