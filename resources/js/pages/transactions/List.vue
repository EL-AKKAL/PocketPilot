<script setup lang="ts">
import DataTable from '@/components/ReusableDatatable/dataTable.vue';
import dataTableTitle from '@/components/ReusableDatatable/dataTableTitle.vue';
import Form from '@/components/ReusableForm/Form.vue';
import { details, inputs, columns } from '@/components/transactions';
import { index } from '@/routes/transactions';
import type { Transaction } from '@/types';

defineProps<{
    transactions: {
        data: Transaction[];
        prev_page_url?: string | null;
        next_page_url?: string | null;
    };
}>();
</script>

<template>
    <div class="container mx-auto py-10">
        <dataTableTitle
            :url="index().url"
            title="Transactions"
            action="Create Transaction"
        >
            <Form :inputs :details />
        </dataTableTitle>
        <DataTable
            :columns
            :data="transactions.data"
            :links="{
                prev: transactions.prev_page_url,
                next: transactions.next_page_url,
            }"
        />
    </div>
</template>
