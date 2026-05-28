<script setup lang="ts">
import { columns } from '@/components/goals/columns';
// import Form from '@/components/goals/Form.vue';
import DataTable from '@/components/ReusableDatatable/dataTable.vue';
import dataTableTitle from '@/components/ReusableDatatable/dataTableTitle.vue';

import type { Goal } from '@/types';

defineProps<{ goalsHistory: Goal[] }>();
</script>

<template>
    <div class="container mx-auto py-10">
        <dataTableTitle title="Goals History" :action="null" />
        <dataTable :columns :data="goalsHistory" />
    </div>
</template>
