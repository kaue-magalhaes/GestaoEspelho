<script setup lang="ts">
import {Promotoria} from "@/Interfaces/Promotoria/Promotoria";
import {useForm, usePage} from "@inertiajs/vue3";
import {Switch} from "@/Components/ui/switch";
import {toast} from "vue-sonner";

const props = defineProps({
    promotoria: {
        type: Object as () => Promotoria,
        required: true
    }
});

const promotores = usePage().props.promotores;
const grupoPromotorias = usePage().props.grupoPromotorias;

const form = useForm({
    nome: props.promotoria.nome,
    promotoria_id: props.promotoria.id,
    espelho_id: props.promotoria.espelho_id,
    promotor_titular_id: props.promotoria.promotor_titular_id,
    grupo_promotoria_id: props.promotoria.grupo_promotoria_id,
    is_especializada: props.promotoria.is_especializada,
})

const submit = () => {
    form.put(route('promotoria.update', props.promotoria.id), {
        onFinish: () => {
            const successMessage = usePage().props.flash.success;
            if (successMessage) {
                toast.success(`${successMessage}`);
            }
        },
    });
}
</script>

<template>
    <form @submit.prevent="submit">
        <div class="space-y-4">
            <div class="space-y-2 col-span-3">
                <Label>
                    Nome
                </Label>
                <Input
                    label="Nome da Promotoria"
                    v-model="form.nome"
                />
            </div>
            <div class="space-y-2 col-span-3">
                <Label>
                    Promotor Titular
                </Label>
                <Select v-model="form.promotor_titular_id">
                    <SelectTrigger>
                        <SelectValue placeholder="Selecione o Promotor"/>
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectLabel>Promotores</SelectLabel>
                            <SelectItem v-for="promotor in promotores"
                                        :key="promotor.id"
                                        :value="promotor.id">
                                {{ promotor.nome }}
                            </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
            </div>
            <div class="space-y-2 col-span-3">
                <Label>
                    Comarca
                </Label>
                <Select v-model="form.grupo_promotoria_id">
                    <SelectTrigger>
                        <SelectValue placeholder="Selecione a Comarca"/>
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectLabel>Comarcas</SelectLabel>
                            <SelectItem v-for="comarca in grupoPromotorias"
                                        :key="comarca.id"
                                        :value="comarca.id">
                                {{ comarca.nome }}
                            </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
            </div>
            <div class="space-y-2 col-span-3">
                <div class="flex flex-row items-center justify-between rounded-lg border p-4">
                    <div class="space-y-0.5">
                        <h1 class="text-base font-semibold text-gray-800">
                            Promotoria Especializada
                        </h1>
                        <p class="text-sm text-gray-500">
                            Selecione se é uma promotoria do tipo "Especializada"
                        </p>
                    </div>
                    <div>
                        <Switch
                            :checked="form.is_especializada"
                            @update:checked="form.is_especializada=!form.is_especializada"
                        />
                    </div>
                </div>
            </div>
            <div class="space-y-2 col-span-3">
                <Button type="submit">
                    Atualizar
                </Button>
            </div>
        </div>
    </form>
</template>
