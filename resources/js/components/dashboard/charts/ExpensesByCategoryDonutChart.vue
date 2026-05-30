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

const series = props.data.map((item) => item.total);

const labels = props.data.map((item) => item.category);

const options = {
    chart: {
        type: 'donut',
    },
    labels,
    legend: {
        position: 'bottom',
    },
    dataLabels: {
        enabled: false,
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
            <CardTitle> Expenses by Category </CardTitle>
            <CardDescription>
                See where your money is going by viewing your expenses
                categorized.
            </CardDescription>
        </CardHeader>
        <CardContent>
            <div v-if="!data.length" class="text-center">No expenses yet.</div>
            <apexchart
                v-else
                height="300"
                :options="options"
                :series="series"
            />
        </CardContent>
    </Card>
</template>
