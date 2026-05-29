<script setup lang="ts">
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

const incomeExpenseOptions = {
    chart: {
        type: 'bar',
    },
    labels: ['Income', 'Expense'],
    colors: ['#22c55e', '#ef4444'],
    legend: {
        position: 'bottom',
    },
    tooltip: {
        y: {
            formatter: (val: number) => val.toFixed(2) + ' MAD',
        },
    },
    dataLabels: {
        formatter: (val: number) => val.toFixed(1) + '%',
    },
};
</script>
<template>
    <apexchart
        type="bar"
        height="300"
        :options="incomeExpenseOptions"
        :series="incomeExpenseSeries"
    />
</template>
