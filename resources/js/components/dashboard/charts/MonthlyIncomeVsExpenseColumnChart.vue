<script setup lang="ts">
import { computed } from 'vue';
import { useChartOptions } from '@/composables/useChartOptions';
import ChartCard from './ChartCard.vue';

const { baseChart, tooltip, axis, yaxis, grid } = useChartOptions();

const props = defineProps<{
    income: number;
    expense: number;
}>();

const incomeExpenseSeries = [
    {
        name: 'Amount',
        data: [props.income, props.expense],
    },
];

const options = {
    series: [
        {
            data: incomeExpenseSeries[0].data,
        },
    ],
    chart: {
        type: 'bar',
        ...baseChart,
    },
    colors: ['#00e396d9', '#ff4560d9'],
    plotOptions: {
        bar: {
            columnWidth: '45%',
            distributed: true,
            borderRadius: 6,
        },
    },
    dataLabels: {
        enabled: false,
    },
    legend: {
        show: false,
    },
    xaxis: {
        categories: ['Income', 'Expense'],
        ...axis,
    },
    yaxis,
    grid,
    tooltip,
};

const hasData = computed(() => !(props.income === 0 && props.expense === 0));
</script>
<template>
    <ChartCard
        title="Income vs Expense this Month"
        description="Compare your total income and expenses for the current month."
        :hasData
    >
        <apexchart
            :options="options"
            height="300"
            :series="incomeExpenseSeries"
        />
    </ChartCard>
</template>
