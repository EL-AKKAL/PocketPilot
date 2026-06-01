<script setup lang="ts">
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import { currency } from '@/lib/utils';
import type { Transaction } from '@/types';
defineProps<{
    transactions: Array<Transaction>;
}>();
</script>

<template>
    <div class="rounded-2xl border p-6">
        <h2 class="mb-4 font-semibold text-primary">Recent Transactions</h2>

        <div
            v-if="transactions?.length === 0"
            class="relative flex aspect-video max-h-42! w-full! items-center justify-center overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
        >
            <PlaceholderPattern />
            <span class="text-gray-400">No data yet.</span>
        </div>

        <ul v-else class="space-y-2">
            <li
                v-for="t in transactions"
                :key="t.id"
                class="flex justify-between border-b pb-2"
            >
                <span>{{ t.description ?? 'No description' }}</span>

                <span
                    :class="t?.amount > 0 ? 'text-green-600' : 'text-red-600'"
                >
                    {{ currency(t?.amount) }}
                </span>
            </li>
        </ul>
    </div>
</template>
