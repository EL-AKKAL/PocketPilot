<script setup lang="ts">
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
    <div v-if="!data.length" class="text-center text-gray-500">
        No expenses yet.
    </div>
    <apexchart
        v-else
        type="donut"
        height="300"
        :options="options"
        :series="series"
    />
</template>
