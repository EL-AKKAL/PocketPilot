<script setup lang="ts">
import { AlertDialog, AlertDialogTrigger } from '@/components/ui/alert-dialog';
import { Button } from '@/components/ui/button';
defineProps<{
    title: string;
    action: string | null;
}>();
</script>
<template>
    <div class="mx-auto flex w-full items-center justify-between px-4">
        <h2 class="text-2xl font-bold tracking-tight">
            {{ title }}
        </h2>
        <AlertDialog class="w-3xl!" v-if="action">
            <AlertDialogTrigger as-child>
                <Button variant="outline" size="sm">{{ action }}</Button>
            </AlertDialogTrigger>
            <slot />
        </AlertDialog>
    </div>
</template>
