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

const options = {
    series: [
        {
            data: incomeExpenseSeries[0].data,
        },
    ],
    chart: {
        height: '300px',
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
            <div
                v-if="
                    !incomeExpenseSeries[0].data[0] &&
                    !incomeExpenseSeries[0].data[1]
                "
                class="text-center"
            >
                No data yet.
            </div>
            <apexchart
                v-else
                :options="options"
                :series="incomeExpenseSeries"
            />
        </CardContent>
    </Card>
</template>
