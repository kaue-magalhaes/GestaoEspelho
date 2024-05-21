<script setup lang="ts">
import {format} from "date-fns";
import {HistoricoEspelhos} from "@/Interfaces/Historico/HistoricoEspelhos";
import { ArrowUpDown } from 'lucide-vue-next'

defineEmits([
    'invertOrderByCreatedAt'
]);

defineProps({
    historicoEspelhos: {
        type: Array as () => HistoricoEspelhos[],
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
            <TableRow v-for="historicoEspelho in historicoEspelhos" :key="historicoEspelho.id">
                <TableCell class="font-medium">
                    {{ historicoEspelho.titulo }}
                </TableCell>
                <TableCell>
                    {{ format(new Date(historicoEspelho.created_at), 'dd/MM/yyyy') }} às
                    {{ format(new Date(historicoEspelho.created_at), 'HH:mm') }} horas
                </TableCell>
                <TableCell>
                    {{ historicoEspelho.user.nome }}
                </TableCell>
                <TableCell>
                    <a :href="`/espelho/historico/${historicoEspelho.id}`">
                        <Button size="sm" variant="link">
                            Visualizar
                        </Button>
                    </a>
                </TableCell>
            </TableRow>
        </TableBody>
    </Table>
</template>
