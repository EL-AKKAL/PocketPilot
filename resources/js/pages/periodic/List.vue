<script setup lang="ts">
import { columns } from '@/components/periodics/columns';
import Form from '@/components/periodics/Form.vue';
import DataTable from '@/components/ReusableDatatable/dataTable.vue';
import { AlertDialog, AlertDialogTrigger } from '@/components/ui/alert-dialog';
import { Button } from '@/components/ui/button';
import type { PeriodicTransaction } from '@/types';

defineProps<{ periodics: PeriodicTransaction[] }>();
</script>

<template>
    <div class="container mx-auto py-10">
        <div class="mx-auto flex w-full items-center justify-between">
            <h2 class="text-2xl font-bold tracking-tight">
                Periodic Transactions
            </h2>
            <AlertDialog class="w-3xl!">
                <AlertDialogTrigger as-child>
                    <Button variant="outline" size="sm"
                        >Create Periodic Transaction</Button
                    >
                </AlertDialogTrigger>
                <Form class="w-3xl!" />
            </AlertDialog>
        </div>
        <dataTable :columns="columns" :data="periodics" />
    </div>
</template>
