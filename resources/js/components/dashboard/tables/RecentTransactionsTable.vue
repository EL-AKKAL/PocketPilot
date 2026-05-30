<script setup lang="ts">
import type { Transaction } from '@/types';
defineProps<{
    transactions: Array<Transaction>;
}>();
</script>

<template>
    <div class="rounded-2xl border p-6">
        <h2 class="mb-4 font-semibold text-primary">Recent Transactions</h2>

        <div class="mx-auto" v-if="transactions?.length === 0">
            No transactions yet.
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
                    {{ t?.amount }}MAD
                </span>
            </li>
        </ul>
    </div>
</template>
