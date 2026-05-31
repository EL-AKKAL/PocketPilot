<script setup lang="ts">
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
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

const isDark = document.documentElement.classList.contains('dark');
const textColor = isDark ? '#e5e7eb' : '#374151';
const gridColor = isDark ? '#374151' : '#e5e7eb';

const options = {
    series: [
        {
            data: incomeExpenseSeries[0].data,
        },
    ],
    chart: {
        height: 300,
        type: 'bar',
        zoom: {
            enabled: false,
        },
        toolbar: {
            show: false,
        },
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
        labels: {
            style: {
                colors: textColor,
                fontSize: '12px',
            },
        },
    },
    yaxis: {
        labels: {
            style: {
                colors: textColor,
            },
            formatter: (val: number) => val.toFixed(0),
        },
    },
    grid: {
        borderColor: gridColor,
    },
    tooltip: {
        theme: isDark ? 'dark' : 'light',
        y: {
            formatter: (val: number) => `${val.toFixed(2)} MAD`,
        },
    },
};
</script>
<template>
    <Card class="w-full shadow-none">
        <CardHeader>
            <CardTitle> Income vs Expense this Month </CardTitle>
            <CardDescription>
                Compare your total income and expenses for the current month to
                see if you're on track with your financial goals.
            </CardDescription>
        </CardHeader>
        <CardContent>
            <div v-if="income === 0 && expense === 0" class="text-center">
                No data yet.
            </div>
            <apexchart
                v-else
                :options="options"
                height="300"
                :series="incomeExpenseSeries"
            />
        </CardContent>
    </Card>
</template>
