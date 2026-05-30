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

const options = {
    series: [
        {
            data: incomeExpenseSeries[0].data,
        },
    ],
    chart: {
        height: 350,
        type: 'bar',
    },
    colors: ['#00e396d9', '#ff4560d9'],
    plotOptions: {
        bar: {
            columnWidth: '45%',
            distributed: true,
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
        labels: {
            style: {
                colors: ['#00e396d9', '#ff4560d9'],
                fontSize: '12px',
            },
        },
    },
};
// const incomeExpenseOptions = {
//     chart: {
//         type: 'bar',
//     },
//     labels: ['Income', 'Expense'],
//     colors: ['#22c55e', '#ef4444'],
//     legend: {
//         position: 'bottom',
//     },
//     tooltip: {
//         y: {
//             formatter: (val: number) => val.toFixed(2) + ' MAD',
//         },
//     },
//     dataLabels: {
//         formatter: (val: number) => val.toFixed(1) + '%',
//     },
// };
</script>
<template>
    <apexchart :options="options" :series="incomeExpenseSeries" />
</template>
