<script setup lang="ts">
import { columns } from '@/components/periodics/columns';
import Form from '@/components/periodics/Form.vue';
import DataTable from '@/components/ReusableDatatable/dataTable.vue';
import dataTableTitle from '@/components/ReusableDatatable/dataTableTitle.vue';

import type { PeriodicTransaction } from '@/types';

defineProps<{ periodics: PeriodicTransaction[] }>();
</script>

<template>
    <div class="container mx-auto py-10">
        <dataTableTitle
            title="Periodic Transactions"
            action="Create Periodic Transaction"
        >
            <Form />
        </dataTableTitle>
        <dataTable :columns="columns" :data="periodics" />
    </div>
</template>
