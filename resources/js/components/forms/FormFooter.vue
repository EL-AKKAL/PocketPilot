<script setup lang="ts">
import {
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogFooter,
} from '@/components/ui/alert-dialog';
import { Spinner } from '@/components/ui/spinner';

defineProps<{
    processing: boolean;
    entity?: object | null;
}>();
</script>

<template>
    <AlertDialogFooter>
        <AlertDialogCancel>Cancel</AlertDialogCancel>
        <AlertDialogAction type="submit" :disabled="processing">
            <Spinner v-if="processing" />
            <span v-else>
                {{ entity ? 'Update' : 'Create' }}
            </span>
        </AlertDialogAction>
    </AlertDialogFooter>
</template>
