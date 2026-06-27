<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import CategorySuggestionsModal from '@/components/categories/CategorySuggestionsModal.vue';
import BalanceHistoryLineChart from '@/components/dashboard/charts/BalanceHistoryLineChart.vue';
import ExpensesByCategoryDonutChart from '@/components/dashboard/charts/ExpensesByCategoryDonutChart.vue';
import MonthlyIncomeVsExpenseColumnChart from '@/components/dashboard/charts/MonthlyIncomeVsExpenseColumnChart.vue';
import RecentTransactionsTable from '@/components/dashboard/tables/RecentTransactionsTable.vue';
import GoalWidget from '@/components/dashboard/widgets/GoalWidget.vue';
import MostUsedCategoriesWidget from '@/components/dashboard/widgets/MostUsedCategoriesWidget.vue';
import StatsWidget from '@/components/dashboard/widgets/StatsWidget.vue';
import type {
    Transaction,
    GoalStatistic,
    MostUsedCategories,
    SuggestedCategories,
} from '@/types';

defineProps<{
    balance: number;
    income: number;
    expense: number;
    recentTransactions: Array<Transaction>;
    balanceHistory: Array<{
        date: string;
        balance: number;
    }>;
    goal: GoalStatistic;
    canCreateGoal: boolean;
    expensesByCategory: {
        category: string;
        total: number;
    }[];
    mostUsedCategories: MostUsedCategories;
}>();

const page = usePage();

const flash = page.props.flash as {
    showCategorySuggestions?: boolean;
    suggestedCategories?: SuggestedCategories;
};

const month = new Date().toLocaleString('en-US', { month: 'short' });
</script>

<template>
    <div class="space-y-6 p-6!">
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <div class="space-y-5">
                <StatsWidget :value="balance" title="Total Balance" />
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
            <RecentTransactionsTable :transactions="recentTransactions" />
        </div>
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <GoalWidget :canCreateGoal :goal="goal" />
            <MostUsedCategoriesWidget :mostUsedCategories :month="month" />
        </div>
        <BalanceHistoryLineChart :balanceHistory />
        <div class="grid w-full grid-cols-1 gap-6 lg:grid-cols-2">
            <ExpensesByCategoryDonutChart :data="expensesByCategory" />
            <MonthlyIncomeVsExpenseColumnChart
                :income="income"
                :expense="expense"
            />
        </div>

        <CategorySuggestionsModal
            :suggestedCategories="flash.suggestedCategories"
            v-if="flash.showCategorySuggestions"
        />
    </div>
</template>
