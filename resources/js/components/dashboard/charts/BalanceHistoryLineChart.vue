<script setup lang="ts">
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';

const props = defineProps<{
    balanceHistory: Array<{
        date: string;
        balance: number;
    }>;
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
        type: 'line',
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
</script>
<template>
    <Card class="w-full shadow-none">
        <CardHeader>
            <CardTitle> Balance history </CardTitle>
            <CardDescription>
                The balance history over the last 10 days.
            </CardDescription>
        </CardHeader>
        <CardContent>
            <div v-if="!series[0].data.length" class="text-center">
                No data yet.
            </div>
            <apexchart
                v-else
                height="300"
                :options="options"
                :series="series"
            />
        </CardContent>
    </Card>
</template>
