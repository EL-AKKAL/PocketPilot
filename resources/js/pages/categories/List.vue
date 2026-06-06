<script setup lang="ts">
import { columns } from '@/components/categories/columns';
import Form from '@/components/categories/Form.vue';
import DataTable from '@/components/ReusableDatatable/dataTable.vue';
import dataTableTitle from '@/components/ReusableDatatable/dataTableTitle.vue';
import type { Category } from '@/types';

defineProps<{
    categories: {
        data: Category[];
        prev_page_url?: string | null;
        next_page_url?: string | null;
    };
}>();
</script>

<template>
    <div class="container mx-auto py-10">
        <dataTableTitle title="Categories" action="Create Category">
            <Form />
        </dataTableTitle>
        <DataTable
            :columns
            :data="categories.data"
            :links="{
                prev: categories.prev_page_url,
                next: categories.next_page_url,
            }"
        />
    </div>
</template>
