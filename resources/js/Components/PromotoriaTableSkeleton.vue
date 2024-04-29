<script setup lang="ts">
import {Skeleton} from "@/Components/ui/skeleton";

</script>

<template>
    <Table>
        <TableHeader>
            <TableRow>
                <TableHead>
                    <Skeleton class="h-4 w-[150px]" />

                </TableHead>
                <TableHead>
                    <Skeleton class="h-4 w-[150px]" />
                </TableHead>
                <TableHead class="w-[100px]">

                </TableHead>
            </TableRow>
        </TableHeader>
        <TableBody>
            <TableRow>
                <TableCell class="font-medium">
                    <Skeleton class="h-4 w-[400px]" />
                </TableCell>
                <TableCell>
                    <Skeleton class="h-4 w-[200px]" />
                </TableCell>
            </TableRow>
            <TableRow>
                <TableCell class="font-medium">
                    <Skeleton class="h-4 w-[250px]" />
                </TableCell>
                <TableCell>
                    <Skeleton class="h-4 w-[200px]" />
                </TableCell>
            </TableRow>
            <TableRow>
                <TableCell class="font-medium">
                    <Skeleton class="h-4 w-[400px]" />
                </TableCell>
                <TableCell>
                    <Skeleton class="h-4 w-[200px]" />
                </TableCell>
            </TableRow>
            <TableRow>
                <TableCell class="font-medium">
                    <Skeleton class="h-4 w-[350px]" />
                </TableCell>
                <TableCell>
                    <Skeleton class="h-4 w-[200px]" />
                </TableCell>
            </TableRow>
            <TableRow>
                <TableCell class="font-medium">
                    <Skeleton class="h-4 w-[400px]" />
                </TableCell>
                <TableCell>
                    <Skeleton class="h-4 w-[200px]" />
                </TableCell>
            </TableRow>
            <TableRow>
                <TableCell class="font-medium">
                    <Skeleton class="h-4 w-[300px]" />
                </TableCell>
                <TableCell>
                    <Skeleton class="h-4 w-[200px]" />
                </TableCell>
            </TableRow>
            <TableRow>
                <TableCell class="font-medium">
                    <Skeleton class="h-4 w-[400px]" />
                </TableCell>
                <TableCell>
                    <Skeleton class="h-4 w-[200px]" />
                </TableCell>
            </TableRow>
            <TableRow>
                <TableCell class="font-medium">
                    <Skeleton class="h-4 w-[350px]" />
                </TableCell>
                <TableCell>
                    <Skeleton class="h-4 w-[200px]" />
                </TableCell>
            </TableRow>
        </TableBody>
    </Table>
</template>
