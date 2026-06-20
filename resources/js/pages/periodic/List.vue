<script setup lang="ts">
import { columns } from '@/components/periodics/columns';
import { filters } from '@/components/periodics/filters';
import Form from '@/components/periodics/Form.vue';
import DataTable from '@/components/ReusableDatatable/dataTable.vue';
import dataTableTitle from '@/components/ReusableDatatable/dataTableTitle.vue';
import { index } from '@/routes/periodic_transactions';

import type { PeriodicTransaction } from '@/types';

defineProps<{
    periodics: {
        data: PeriodicTransaction[];
        prev_page_url?: string | null;
        next_page_url?: string | null;
    };
}>();
</script>

<template>
    <div class="container mx-auto py-10">
        <dataTableTitle
            :url="index().url"
            title="Periodic Transactions"
            action="Create Periodic Transaction"
            :filters
        >
            <Form />
        </dataTableTitle>
        <dataTable
            :columns
            :data="periodics.data"
            :links="{
                prev: periodics.prev_page_url,
                next: periodics.next_page_url,
            }"
        />
    </div>
</template>
