<script setup lang="ts">
import { columns } from '@/components/debts/columns';
import Form from '@/components/debts/Form.vue';
import DataTable from '@/components/ReusableDatatable/dataTable.vue';
import dataTableTitle from '@/components/ReusableDatatable/dataTableTitle.vue';
import { index } from '@/routes/debts';
import type { Debt } from '@/types';

defineProps<{
    debts: {
        data: Debt[];
        prev_page_url?: string | null;
        next_page_url?: string | null;
    };
}>();
</script>

<template>
    <div class="container mx-auto py-10">
        <dataTableTitle title="Debts" action="Create Debt" :url="index().url">
            <Form />
        </dataTableTitle>
        <DataTable
            :columns
            :data="debts.data"
            :links="{
                prev: debts.prev_page_url,
                next: debts.next_page_url,
            }"
        />
    </div>
</template>
