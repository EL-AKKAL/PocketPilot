<script setup lang="ts">
import DataTable from '@/components/ReusableDatatable/dataTable.vue';
import dataTableTitle from '@/components/ReusableDatatable/dataTableTitle.vue';
import { columns } from '@/components/transactions/columns';
import Form from '@/components/transactions/Form.vue';
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
        <dataTableTitle title="Transactions" action="Create Transaction">
            <Form />
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
