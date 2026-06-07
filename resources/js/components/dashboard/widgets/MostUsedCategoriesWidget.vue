<script setup lang="ts">
import { categoryStyles, currency } from '@/lib/utils';
import type { MostUsedCategories } from '@/types';
defineProps<{
    mostUsedCategories: MostUsedCategories;
    month: string;
}>();
</script>
<template>
    <div class="space-y-4 rounded-2xl border p-4">
        <h3 class="text-lg font-semibold">
            Most Used Categories of {{ month }}
        </h3>

        <!-- Income -->
        <div
            class="flex flex-col gap-2 lg:flex-row lg:items-center lg:justify-between"
        >
            <span class="font-medium text-green-600">Income</span>

            <span class="flex gap-2 text-sm" v-if="mostUsedCategories.income">
                <span :class="categoryStyles">
                    {{ mostUsedCategories.income.category }}
                </span>
                ({{ mostUsedCategories.income.count }} transactions •
                {{ currency(mostUsedCategories.income.total_amount) }})
            </span>

            <span v-else class="text-sm text-gray-400"> No data </span>
        </div>

        <!-- Expense -->
        <div
            class="flex flex-col gap-2 lg:flex-row lg:items-center lg:justify-between"
        >
            <span class="font-medium text-red-600">Expense</span>

            <span class="flex gap-2 text-sm" v-if="mostUsedCategories.expense">
                <span :class="categoryStyles">
                    {{ mostUsedCategories.expense.category }}
                </span>
                ({{ mostUsedCategories.expense.count }} transactions •
                {{ currency(mostUsedCategories.expense.total_amount) }}
                )
            </span>

            <span v-else class="text-sm text-gray-400"> No data </span>
        </div>
    </div>
</template>
