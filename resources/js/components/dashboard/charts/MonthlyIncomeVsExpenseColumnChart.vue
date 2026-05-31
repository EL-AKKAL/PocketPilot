<script setup lang="ts">
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { useChartOptions } from '@/composables/useChartOptions';

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
