<script setup lang="ts">
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
const props = defineProps<{
    data: {
        category: string;
        total: number;
    }[];
}>();

const isDark = document.documentElement.classList.contains('dark');

const series = props.data.map((item) => item.total);

const labels = props.data.map((item) => item.category);

const options = {
    chart: {
        height: 300,
        type: 'donut',
        zoom: {
            enabled: false,
        },
        toolbar: {
            show: false,
        },
    },
    labels,
    colors: ['#f97316', '#22c55e', '#3b82f6', '#eab308', '#ef4444', '#a855f7'],

    stroke: {
        width: 0,
    },
    legend: {
        show: false,
    },
    dataLabels: {
        enabled: false,
    },
    tooltip: {
        theme: isDark ? 'dark' : 'light',
        y: {
            formatter: (val: number) => `${val.toFixed(2)} MAD`,
        },
    },
    plotOptions: {
        pie: {
            donut: {
                size: '70%',
            },
        },
    },
};
const total = series.reduce((sum, val) => sum + val, 0);

const enrichedData = props.data.map((item) => ({
    ...item,
    percentage: total ? ((item.total / total) * 100).toFixed(1) : 0,
}));
</script>
<template>
    <Card class="w-full shadow-none">
        <CardHeader>
            <CardTitle> Expenses by Category </CardTitle>
            <CardDescription>
                See where your money is going by viewing your expenses
                categorized.
            </CardDescription>
        </CardHeader>
        <CardContent>
            <div v-if="!data.length" class="text-center">No expenses yet.</div>
            <div
                v-else
                class="grid min-h-80 grid-cols-1 items-center lg:grid-cols-2"
            >
                <apexchart :options="options" :series="series" />

                <div class="no-scrollbar max-h-32! space-y-2 overflow-y-auto">
                    <div
                        v-for="(item, index) in enrichedData"
                        :key="item.category"
                        class="flex items-center justify-between text-sm"
                    >
                        <div class="flex items-center gap-2">
                            <span
                                class="h-3 w-3 rounded-full"
                                :style="{
                                    backgroundColor: options.colors[index],
                                }"
                            />

                            <span class="font-medium">
                                {{ item.category }}
                            </span>
                        </div>

                        <div class="text-right text-xs text-gray-400">
                            {{ item.total.toFixed(2) }} MAD •
                            {{ item.percentage }}%
                        </div>
                    </div>
                </div>
            </div>
        </CardContent>
    </Card>
</template>
