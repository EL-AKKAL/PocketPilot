<script setup lang="ts">
import DataTable from '@/components/ReusableDatatable/dataTable.vue';
import { columns } from '@/components/transactions/columns';
import Form from '@/components/transactions/Form.vue';
import { AlertDialog, AlertDialogTrigger } from '@/components/ui/alert-dialog';
import { Button } from '@/components/ui/button';
import type { Transaction } from '@/types';

defineProps<{ transactions: Transaction[] }>();
</script>

<template>
    <div class="container mx-auto py-10">
        <div class="mx-auto flex w-full items-center justify-between">
            <h2 class="text-2xl font-bold tracking-tight">Transactions</h2>
            <AlertDialog>
                <AlertDialogTrigger as-child>
                    <Button variant="outline" size="sm"
                        >Create Transaction</Button
                    >
                </AlertDialogTrigger>
                <Form />
            </AlertDialog>
        </div>
        <DataTable :columns="columns" :data="transactions" />
    </div>
</template>
