<script setup>
defineProps({
    balance: Number,
    income: Number,
    expense: Number,
    recentTransactions: Array,
});
</script>

<template>
    <div class="space-y-6 p-6">
        <!-- Balance -->
        <div class="rounded-2xl bg-white p-6 shadow">
            <h2 class="text-gray-500">Total Balance</h2>
            <p class="mt-2 text-3xl font-bold">{{ balance?.toFixed(2) }}MAD</p>
        </div>

        <!-- Income vs Expense -->
        <div class="grid grid-cols-2 gap-4">
            <div class="rounded-xl bg-green-100 p-4">
                <h3 class="text-green-700">Income</h3>
                <p class="text-xl font-bold">{{ income.toFixed(2) }}MAD</p>
            </div>

            <div class="rounded-xl bg-red-100 p-4">
                <h3 class="text-red-700">Expense</h3>
                <p class="text-xl font-bold">{{ expense?.toFixed(2) }}MAD</p>
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="rounded-2xl bg-white p-6 shadow">
            <h2 class="mb-4 font-semibold">Recent Transactions</h2>

            <div v-if="recentTransactions?.length === 0">
                No transactions yet.
            </div>

            <ul v-else class="space-y-2">
                <li
                    v-for="t in recentTransactions"
                    :key="t.id"
                    class="flex justify-between border-b pb-2"
                >
                    <span>{{ t.description ?? 'No description' }}</span>

                    <span
                        :class="
                            t?.amount > 0 ? 'text-green-600' : 'text-red-600'
                        "
                    >
                        {{ t?.amount }}MAD
                    </span>
                </li>
            </ul>
        </div>
    </div>
</template>
