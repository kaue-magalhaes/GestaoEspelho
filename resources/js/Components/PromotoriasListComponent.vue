<script setup lang="ts">
import {format} from "date-fns";
import { ArrowUpDown } from 'lucide-vue-next'
import {Promotoria} from "@/Interfaces/Promotoria/Promotoria";

defineEmits([
    'invertOrderByCreatedAt'
]);

defineProps({
    promotorias: {
        type: Array as () => Promotoria[],
        required: true
    }
});
</script>

<template>
    <Table>
        <TableHeader>
            <TableRow>
                <TableHead>
                    Espelho
                </TableHead>
                <TableHead>
                    <Button variant="ghost" @click="$emit('invertOrderByCreatedAt')">
                        Data de Publicação
                        <ArrowUpDown class="ml-2 w-4 h-4" />
                    </Button>
                </TableHead>
                <TableHead class="w-[100px]">

                </TableHead>
            </TableRow>
        </TableHeader>
        <TableBody>
            <TableRow v-for="promotoria in promotorias" :key="promotoria.id">
                <TableCell class="font-medium">
                    {{ promotoria.nome }}
                </TableCell>
                <TableCell>
                    {{ format(new Date(promotoria.created_at), 'dd/MM/yyyy') }} às
                    {{ format(new Date(promotoria.created_at), 'HH:mm') }} horas
                </TableCell>
            </TableRow>
        </TableBody>
    </Table>
</template>
