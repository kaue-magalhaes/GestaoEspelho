<script setup lang="ts">
import {format} from "date-fns";
import {Espelhos} from "@/Interfaces/Espelhos";
import { ArrowUpDown } from 'lucide-vue-next'

defineEmits([
    'invertOrderByCreatedAt'
]);

defineProps({
    espelhos: {
        type: Array as () => Espelhos[],
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
                <TableHead>
                    Publicado por
                </TableHead>
                <TableHead class="w-[100px]">

                </TableHead>
            </TableRow>
        </TableHeader>
        <TableBody>
            <TableRow v-for="espelho in espelhos" :key="espelho.id">
                <TableCell class="font-medium">
                    {{ espelho.titulo }}
                </TableCell>
                <TableCell>
                    {{ format(new Date(espelho.created_at), 'dd/MM/yyyy') }} às
                    {{ format(new Date(espelho.created_at), 'HH:mm') }} horas
                </TableCell>
                <TableCell>
                    {{ espelho.user.nome }}
                </TableCell>
                <TableCell>
                    <a :href="`/espelho/historico/${espelho.id}`">
                        <Button size="sm" variant="link">
                            Visualizar
                        </Button>
                    </a>
                </TableCell>
            </TableRow>
        </TableBody>
    </Table>
</template>
