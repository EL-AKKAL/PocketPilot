<script setup lang="ts">
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import { currency } from '@/lib/utils';
import type { UpcomingObligations } from '@/types';
defineProps<{
    upcomingObligations: UpcomingObligations[];
}>();
</script>

<template>
    <div class="rounded-2xl border p-6">
        <h2 class="mb-4 font-semibold text-primary">Upcoming Obligations</h2>

        <div
            v-if="upcomingObligations?.length === 0"
            class="relative flex aspect-video max-h-42! w-full! items-center justify-center overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
        >
            <PlaceholderPattern />
            <span class="text-gray-400">No data yet.</span>
        </div>

        <ul v-else class="space-y-2">
            <li
                v-for="obligation in upcomingObligations"
                :key="obligation.title"
                class="flex items-center justify-between gap-2 border-b pb-2"
            >
                <span
                    class="block size-3 rounded-full"
                    :class="
                        obligation.type == 'Debt' ? 'bg-primary' : 'bg-blue-500'
                    "
                />
                <span class="hidden lg:block">{{ obligation.title }}</span>
                <span>{{ currency(obligation?.amount) }}</span>
                <span>{{ obligation.human_date }}</span>
            </li>
        </ul>
    </div>
</template>
