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

const isDark = document.documentElement.classList.contains('dark');

const textColor = isDark ? '#e5e7eb' : '#374151';
const gridColor = isDark ? '#374151' : '#e5e7eb';
const chartWidth = props.balanceHistory.length * 70;

const series = [
    {
        name: 'Balance',
        data: props.balanceHistory.map((item) => item.balance),
    },
];

const options = {
    chart: {
        type: 'line',
        height: 300,
        toolbar: {
            show: false,
        },
        zoom: {
            enabled: false,
        },
    },
    stroke: {
        curve: 'smooth',
        width: 3,
    },
    colors: ['#f97316'],
    xaxis: {
        categories: props.balanceHistory.map((i) =>
            new Date(i.date).toLocaleDateString('en-US', {
                day: '2-digit',
                month: 'short',
            }),
        ),
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
        x: {
            formatter: (val: string) => val,
        },
        y: {
            formatter: (val: number) => `${val.toFixed(2)} MAD`,
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
            <div
                class="no-scrollbar w-full overflow-x-auto overflow-y-hidden"
                style="
                    scroll-snap-type: x mandatory;
                    -webkit-overflow-scrolling: touch;
                "
                v-else
            >
                <div
                    :style="{ minWidth: chartWidth + 'px' }"
                    style="scroll-snap-align: center"
                >
                    <apexchart :options="options" :series="series" />
                </div>
            </div>
        </CardContent>
    </Card>
</template>
