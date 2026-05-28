<script setup lang="ts">
import { Plus } from 'lucide-vue-next';
import GoalForm from '@/components/goals/Form.vue';
import GoalWidget from '@/components/goals/GoalWidget.vue';
import { AlertDialog, AlertDialogTrigger } from '@/components/ui/alert-dialog';
import Button from '@/components/ui/button/Button.vue';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import type { Transaction, GoalStatistic } from '@/types';

const props = defineProps<{
    balance: number;
    income: number;
    expense: number;
    recentTransactions: Array<Transaction>;
    balanceHistory: Array<object>;
    goal: GoalStatistic;
    canCreateGoal: boolean;
}>();

const series = [
    {
        name: 'Balance',
        data: props.balanceHistory.map((item) => item.balance),
    },
];

const options = {
    chart: {
        toolbar: { show: false },
    },
    stroke: {
        curve: 'smooth',
        width: 3,
    },
    colors: ['#f97316'], // your brand color
    xaxis: {
        categories: props.balanceHistory.map((i) => i.date),
    },
    tooltip: {
        y: {
            formatter: (val: number) => val.toFixed(2) + ' MAD',
        },
    },
};
</script>

<template>
    <div class="space-y-6 p-6!">
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <div class="space-y-5">
                <!-- Balance -->
                <div class="rounded-2xl border p-6 shadow">
                    <h2 class="text-2xl font-bold text-primary">
                        Total Balance
                    </h2>
                    <p class="mt-2 text-3xl font-bold">
                        {{ balance?.toFixed(2) }}MAD
                    </p>
                </div>

                <!-- Income vs Expense -->
                <div class="grid grid-cols-2 gap-4">
                    <div
                        class="flex flex-col items-start justify-center gap-4 rounded-xl border p-4 shadow"
                    >
                        <h3 class="font-bold text-green-700">Income</h3>
                        <p class="text-xl font-bold">
                            {{ income?.toFixed(2) }}MAD
                        </p>
                    </div>

                    <div
                        class="flex flex-col items-start justify-center gap-4 rounded-xl border p-4 shadow"
                    >
                        <h3 class="font-bold text-red-700">Expense</h3>
                        <p class="text-xl font-bold">
                            {{ expense?.toFixed(2) }}MAD
                        </p>
                    </div>
                </div>
            </div>

            <!-- Recent Transactions -->
            <div class="rounded-2xl border bg-accent/20 p-6 shadow">
                <h2 class="mb-4 font-semibold text-primary">
                    Recent Transactions
                </h2>

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
                                t?.amount > 0
                                    ? 'text-green-600'
                                    : 'text-red-600'
                            "
                        >
                            {{ t?.amount }}MAD
                        </span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <Card>
                <CardContent>
                    <div v-if="goal">
                        <GoalWidget :goal="goal" />
                    </div>

                    <div
                        v-else-if="canCreateGoal"
                        class="flex w-full items-center justify-between"
                    >
                        No active goal.
                        <AlertDialog class="w-3xl!">
                            <AlertDialogTrigger as-child>
                                <Button
                                    size="icon-sm"
                                    variant="outline"
                                    class="rounded-full"
                                >
                                    <Plus class="h-5 w-5" />
                                </Button>
                            </AlertDialogTrigger>
                            <GoalForm />
                        </AlertDialog>
                    </div>
                </CardContent>
            </Card>
            <Card>
                <CardContent> Coming soon </CardContent>
            </Card>
        </div>

        <Card class="w-full text-2xl">
            <CardHeader>
                <CardTitle class="flex gap-3"> Balance history </CardTitle>
                <CardDescription class="text-lg">
                    The balance history over the last 30 days.
                </CardDescription>
            </CardHeader>
            <CardContent>
                <apexchart
                    type="line"
                    height="300"
                    :options="options"
                    :series="series"
                />
            </CardContent>
        </Card>
    </div>
</template>
