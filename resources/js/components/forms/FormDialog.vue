<script setup lang="ts">
import {
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogHeader,
    AlertDialogTitle,
} from '@/components/ui/alert-dialog';

defineProps<{
    title: string;
    description?: string;
}>();
</script>

<template>
    <AlertDialogContent>
        <AlertDialogHeader>
            <AlertDialogTitle>
                {{ title }}
            </AlertDialogTitle>

            <AlertDialogDescription v-if="description">
                {{ description }}
            </AlertDialogDescription>
        </AlertDialogHeader>

        <slot />
    </AlertDialogContent>
</template>
