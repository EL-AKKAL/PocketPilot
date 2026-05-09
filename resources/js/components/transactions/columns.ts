import type { ColumnDef } from '@tanstack/vue-table';
import { h } from 'vue';
import DropdownAction from '@/components/transactions/dataTableDropdown.vue';
import type { Transaction } from '@/types';

export const columns: ColumnDef<Transaction>[] = [
    {
        accessorKey: 'ID',
        cell: ({ row }) => {
            return h(
                'div',
                { class: 'text-right font-medium' },
                row.original.id,
            );
        },
    },
    {
        accessorKey: 'Amount',
        cell: ({ row }) => {
            const amount = row.original.amount;
            const formatted =
                new Intl.NumberFormat('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2,
                }).format(amount) + ' MAD';

            return h('div', { class: ' font-medium' }, formatted);
        },
    },
    {
        accessorKey: 'Description',
        cell: ({ row }) => {
            return h(
                'div',
                { class: ' font-medium' },
                row.original.description,
            );
        },
    },
    {
        id: 'actions',
        accessorKey: 'actions',
        cell: ({ row }) => {
            const transaction = row.original as Transaction;

            return h(
                'div',
                { class: 'relative' },
                h(DropdownAction, {
                    transaction: transaction,
                }),
            );
        },
    },
];
