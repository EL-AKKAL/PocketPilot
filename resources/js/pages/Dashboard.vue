<script setup lang="ts">
import { Plus } from 'lucide-vue-next';
import ExpensesByCategoryChart from '@/components/dashboard/ExpensesByCategoryChart.vue';
import MonthlyIncomeVsExpenseChart from '@/components/dashboard/MonthlyIncomeVsExpenseChart.vue';
import MostUsedCategoriesWidget from '@/components/dashboard/widgets/MostUsedCategoriesWidget.vue';
import StatsWidget from '@/components/dashboard/widgets/StatsWidget.vue';
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
import type { Transaction, GoalStatistic, MostUsedCategories } from '@/types';

const props = defineProps<{
    balance: number;
    income: number;
    expense: number;
    recentTransactions: Array<Transaction>;
    balanceHistory: Array<object>;
    goal: GoalStatistic;
    canCreateGoal: boolean;
    expensesByCategory: {
        category: string;
        total: number;
    }[];
    mostUsedCategories: MostUsedCategories;
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
    colors: ['#f97316'],
    xaxis: {
        categories: props.balanceHistory.map((i) => i.date),
    },
    tooltip: {
        y: {
            formatter: (val: number) => val.toFixed(2) + ' MAD',
        },
    },
};
const month = new Date().toLocaleString('en-US', { month: 'short' });
</script>

<template>
    <div class="space-y-6 p-6!">
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <div class="space-y-5">
                <!-- Balance -->
                <StatsWidget :value="balance" title="Total Balance" />

                <!-- Income vs Expense -->
                <div class="grid grid-cols-2 gap-4">
                    <StatsWidget
                        variant="success"
                        size="sm"
                        :value="income"
                        :title="'Income : ' + month"
                    />
                    <StatsWidget
                        variant="danger"
                        size="sm"
                        :value="expense"
                        :title="'Expense : ' + month"
                    />
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
            <Card class="shadow-none">
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
            <MostUsedCategoriesWidget
                :mostUsedCategories="mostUsedCategories"
                :month="month"
            />
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
        <Card class="w-full text-2xl">
            <CardHeader>
                <CardTitle class="flex gap-3"> Expenses by Category </CardTitle>
                <CardDescription class="text-lg">
                    See where your money is going by viewing your expenses
                    categorized.
                </CardDescription>
            </CardHeader>
            <CardContent>
                <ExpensesByCategoryChart :data="expensesByCategory" />
            </CardContent>
        </Card>
        <Card class="w-full text-2xl">
            <CardHeader>
                <CardTitle class="flex gap-3">
                    Income vs Expense this Month
                </CardTitle>
                <CardDescription class="text-lg">
                    Compare your total income and expenses for the current month
                    to see if you're on track with your financial goals.
                </CardDescription>
            </CardHeader>
            <CardContent>
                <MonthlyIncomeVsExpenseChart
                    :income="income"
                    :expense="expense"
                />
            </CardContent>
        </Card>
    </div>
</template>
