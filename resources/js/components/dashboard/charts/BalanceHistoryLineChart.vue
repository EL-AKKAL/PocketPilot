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
    balanceHistory: Array<{
        date: string;
        balance: number;
    }>;
}>();

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
        ...baseChart,
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
                    <apexchart
                        height="300"
                        :options="options"
                        :series="series"
                    />
                </div>
            </div>
        </CardContent>
    </Card>
</template>
