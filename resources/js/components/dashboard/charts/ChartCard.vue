<script setup lang="ts">
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';

defineProps<{
    title: string;
    description: string;
    hasData?: boolean;
}>();
</script>
<template>
    <Card class="w-full shadow-none">
        <CardHeader>
            <CardTitle>{{ title }}</CardTitle>
            <CardDescription>{{ description }}</CardDescription>
        </CardHeader>
        <CardContent>
            <div
                v-if="hasData === false"
                class="relative flex aspect-video max-h-75! w-full! items-center justify-center overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
            >
                <PlaceholderPattern />
                <span class="text-gray-400">No data yet.</span>
            </div>
            <slot v-else />
        </CardContent>
    </Card>
</template>
