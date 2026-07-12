<script setup lang="ts">
import { columns, filters } from '@/components/goals';
import DataTable from '@/components/ReusableDatatable/dataTable.vue';
import dataTableTitle from '@/components/ReusableDatatable/dataTableTitle.vue';
import { index } from '@/routes/goals';

import type { Goal } from '@/types';

defineProps<{
    goalsHistory: {
        data: Goal[];
        prev_page_url?: string | null;
        next_page_url?: string | null;
    };
}>();
</script>

<template>
    <div class="container mx-auto py-10">
        <dataTableTitle
            :url="index().url"
            title="Goals History"
            :action="null"
            :filters
        />
        <dataTable
            :columns
            :data="goalsHistory.data"
            :links="{
                prev: goalsHistory.prev_page_url,
                next: goalsHistory.next_page_url,
            }"
        />
    </div>
</template>
