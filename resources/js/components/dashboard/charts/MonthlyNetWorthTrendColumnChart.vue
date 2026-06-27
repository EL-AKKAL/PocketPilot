<script setup lang="ts">
import { computed } from 'vue';
import { useChartOptions } from '@/composables/useChartOptions';
import type { MonthlyNetWorthTrend } from '@/types/index.js';
import ChartCard from './ChartCard.vue';

const { baseChart, tooltip, axis, yaxis, grid } = useChartOptions();

const props = defineProps<{
    monthlyNetWorthTrend: MonthlyNetWorthTrend[];
}>();

const series = [
    {
        name: 'Income',
        data: props.monthlyNetWorthTrend.map((m) => m.income),
    },
    {
        name: 'Expense',
        data: props.monthlyNetWorthTrend.map((m) => m.expense),
    },
    {
        name: 'Net',
        data: props.monthlyNetWorthTrend.map((m) => m.net),
    },
];

const options = {
    chart: {
        type: 'bar',
        stacked: false,
        ...baseChart,
    },
    colors: ['#00E396', '#FF4560', '#008FFB'],
    plotOptions: {
        bar: {
            columnWidth: '60%',
            borderRadius: 6,
        },
    },
    dataLabels: {
        enabled: false,
    },
    xaxis: {
        categories: props.monthlyNetWorthTrend.map((m) => m.month),
        ...axis,
    },
    yaxis,
    grid,
    tooltip,
};

const hasData = computed(() => props.monthlyNetWorthTrend.length > 0);
</script>
<template>
    <ChartCard
        title="Income vs Expense this Month"
        description="Compare your total income and expenses for the current month."
        :hasData
    >
        <apexchart :options="options" height="300" :series />
    </ChartCard>
</template>
