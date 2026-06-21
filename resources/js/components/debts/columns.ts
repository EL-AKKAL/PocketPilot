import type { ColumnDef } from '@tanstack/vue-table';
import { h } from 'vue';
import DropdownAction from '@/components/ReusableDatatable/dataTableDropdown.vue';
import Form from '@/components/transactions/Form.vue';
import { currency } from '@/lib/utils';
import { destroy } from '@/routes/debts';
import type { Debt } from '@/types';

export const columns: ColumnDef<Debt>[] = [
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
        accessorKey: 'Due date',
        cell: ({ row }) => {
            return h('div', { class: ' font-medium' }, row.original.due_date);
        },
    },
    {
        accessorKey: 'Paid',
        cell: ({ row }) => {
            return h('div', { class: ' font-medium' }, row.original.paid_at);
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
            const debt = row.original as Debt;

            return h(
                'div',
                { class: 'relative' },
                h(
                    DropdownAction,
                    {
                        item: 'Debt',
                        deleteRoute: {
                            ...destroy({
                                debt: debt.id,
                            }),
                            action: destroy({
                                debt: debt.id,
                            }).url,
                        },
                    },
                    {
                        edit: () =>
                            h(Form, {
                                debt,
                            }),
                    },
                ),
            );
        },
    },
];
