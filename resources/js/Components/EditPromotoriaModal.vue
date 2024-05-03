<script setup lang="ts">
import {Edit} from "lucide-vue-next";
import {Button} from "@/Components/ui/button";
import {Label} from "@/Components/ui/label";
import {Promotoria} from "@/Interfaces/Promotoria/Promotoria";
import {usePage} from "@inertiajs/vue3";
import {usePromotoriaStore} from "@/Stores/promotoria";

defineProps({
    promotoria: {
        type: Object as () => Promotoria,
        required: true
    },
});

const promotores = usePage().props.promotores;
const grupoPromotorias = usePage().props.grupoPromotorias;

const promotoriaStore = usePromotoriaStore();
</script>

<template>
    <AlertDialog>
        <AlertDialogTrigger>
            <Button variant="outline" size="icon">
                <Edit class="w-4 h-4"/>
            </Button>
        </AlertDialogTrigger>
        <AlertDialogContent class="max-w-screen-md w-full">
            <AlertDialogHeader>
                <AlertDialogTitle>
                    Editar Promotorias
                </AlertDialogTitle>
                <AlertDialogDescription>
                    Aqui você pode editar as informações da promotoria.
                </AlertDialogDescription>
            </AlertDialogHeader>
            <div class="grid grid-cols-6 gap-y-2 gap-x-4">
                <div class="space-y-2 col-span-3">
                    <Label>
                        Nome
                    </Label>
                    <Input
                        label="Nome da Promotoria"
                        v-model="promotoria.nome"
                    />
                </div>
                <div class="space-y-2 col-span-3">
                    <Label>
                        Promotor Titular
                    </Label>
                    <Select v-model="promotoria.promotor_titular_id">
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
                    <Select v-model="promotoria.grupo_promotoria_id">
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
                    <Label>
                        Especializada
                    </Label>
                    <Select v-model="promotoria.is_especializada">
                        <SelectTrigger>
                            <SelectValue placeholder="Selecione uma opção"/>
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectItem :value="true">
                                    Sim
                                </SelectItem>
                                <SelectItem :value="false">
                                    Não
                                </SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>
                </div>
            </div>
            <AlertDialogFooter>
                <AlertDialogCancel>
                    Cancelar
                </AlertDialogCancel>
                <AlertDialogAction
                    @click="promotoriaStore.editPromotoria(promotoria.id, promotoria)"
                >
                    Salvar
                </AlertDialogAction>
            </AlertDialogFooter>
        </AlertDialogContent>
    </AlertDialog>
</template>
