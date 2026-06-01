<script setup lang="ts">
import { cn, currency } from '@/lib/utils';
import { WidgetVariant } from '.';
defineProps<{
    value: number;
    title: string;
    variant?: WidgetVariant['variant'];
    size?: WidgetVariant['size'];
}>();
</script>
<template>
    <div class="rounded-2xl border border-sidebar-border/70 p-6">
        <h2 :class="cn(WidgetVariant({ variant, size }))">
            {{ title }}
        </h2>
        <p class="mt-2 text-lg font-bold! lg:text-2xl">
            {{ currency(value) }}
        </p>
    </div>
</template>
