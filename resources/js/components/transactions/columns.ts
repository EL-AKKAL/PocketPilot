import type { ColumnDef } from '@tanstack/vue-table';
import { h } from 'vue';
import DropdownAction from '@/components/ReusableDatatable/dataTableDropdown.vue';
import Form from '@/components/transactions/Form.vue';
import { categoryStyles, currency } from '@/lib/utils';
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
            return h(
                'div',
                { class: ' font-medium' },
                currency(row.original.amount),
            );
        },
    },
    {
        accessorKey: 'Category',
        cell: ({ row }) => {
            const category = row.original.category;

            return h(
                'span',
                {
                    class: categoryStyles,
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
