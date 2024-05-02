<script setup lang="ts">
import {Promotoria} from "@/Interfaces/Promotoria/Promotoria";
import {Button} from "@/Components/ui/button";
import {format} from "date-fns"
import {Check, Edit, Trash, X} from 'lucide-vue-next'
import {TableCell, TableHead} from "@/Components/ui/table";
import {usePromotoriaStore} from "@/Stores/promotoria";
import {Label} from "@/Components/ui/label";
import {usePage} from "@inertiajs/vue3";


defineEmits([
    'invertOrderByCreatedAt'
]);

defineProps({
    promotorias: {
        type: Array as () => Promotoria[],
        required: true
    }
});

const promotoriaStore = usePromotoriaStore();
const promotores = usePage().props.promotores;
</script>

<template>
    <Table>
        <TableHeader>
            <TableRow>
                <TableHead>
                    Promotoria
                </TableHead>
                <TableHead>
                    Promotor Titular
                </TableHead>
                <TableHead>
                    Especializada
                </TableHead>
                <TableHead>
                    Data de criação
                </TableHead>
                <TableHead>
                </TableHead>
            </TableRow>
        </TableHeader>
        <TableBody>
            <TableRow v-for="promotoria in promotorias" :key="promotoria.id">
                <TableCell class="font-medium">
                    {{ promotoria.nome }}
                </TableCell>
                <TableCell>
                    {{ promotoria.promotor?.nome }}
                </TableCell>
                <TableCell>
                    <Check class="w-4 h-4 text-green-500 mx-auto" v-if="promotoria.is_especializada"/>
                    <X class="w-4 h-4 text-red-500 mx-auto" v-else/>
                </TableCell>
                <TableCell>
                    {{ format(new Date(promotoria.created_at), 'dd/MM/yyyy') }} às
                    {{ format(new Date(promotoria.created_at), 'HH:mm') }} horas
                </TableCell>
                <TableCell class="flex space-x-2">
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
                                <AlertDialogAction>
                                    Salvar
                                </AlertDialogAction>
                            </AlertDialogFooter>
                        </AlertDialogContent>
                    </AlertDialog>
                    <AlertDialog>
                        <AlertDialogTrigger>
                            <Button variant="destructive" size="icon">
                                <Trash class="w-4 h-4"/>
                            </Button>
                        </AlertDialogTrigger>
                        <AlertDialogContent>
                            <AlertDialogHeader>
                                <AlertDialogTitle>
                                    Deletar Promotoria
                                </AlertDialogTitle>
                                <AlertDialogDescription>
                                    Você tem certeza que deseja deletar a promotoria?
                                </AlertDialogDescription>
                            </AlertDialogHeader>
                            <AlertDialogFooter>
                                <AlertDialogCancel>
                                    Cancelar
                                </AlertDialogCancel>
                                <AlertDialogAction variant="destructive"
                                                   @click="promotoriaStore.deletePromotoria(promotoria.id)">
                                    Deletar
                                </AlertDialogAction>
                            </AlertDialogFooter>
                        </AlertDialogContent>
                    </AlertDialog>
                </TableCell>
            </TableRow>
        </TableBody>
    </Table>
</template>
