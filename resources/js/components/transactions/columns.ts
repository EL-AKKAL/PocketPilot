import type { ColumnDef } from '@tanstack/vue-table';
import { h } from 'vue';
import DropdownAction from '@/components/ReusableDatatable/dataTableDropdown.vue';
import Form from '@/components/transactions/Form.vue';
import { categoryStyles } from '@/lib/utils';
import { destroy } from '@/routes/transactions';
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
        accessorKey: 'Category',
        cell: ({ row }) => {
            const category = row.original.category;

            return h(
                'span',
                {
                    class: [
                        categoryStyles[category] ??
                            'bg-gray-100 text-gray-700 dark:bg-gray-500/10 dark:text-gray-300',
                    ],
                },
                category,
            );
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
                h(
                    DropdownAction,
                    {
                        item: 'Transaction',
                        deleteRoute: {
                            ...destroy({
                                transaction: transaction.id,
                            }),
                            action: destroy({
                                transaction: transaction.id,
                            }).url,
                        },
                    },
                    {
                        edit: () =>
                            h(Form, {
                                transaction,
                            }),
                    },
                ),
            );
        },
    },
];
