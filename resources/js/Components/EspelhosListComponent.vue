<script setup lang="ts">
import {format} from "date-fns";
import {Espelhos} from "@/Interfaces/Espelhos";

defineProps({
    espelhos: {
        type: Array as () => Espelhos[],
        required: true
    }
});

function stringToDate(dateString: string) {
    const [year, month, day] = dateString.split('-').map(Number);
    return new Date(year, month - 1, day);
}
</script>

<template>
    <Table>
        <TableHeader>
            <TableRow>
                <TableHead>
                    Espelho
                </TableHead>
                <TableHead>
                    Data de Publicação
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
                    {{ espelho.user.name }}
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
