import type { ColumnDef } from '@tanstack/vue-table';
import { Check, X } from 'lucide-vue-next';
import { h } from 'vue';
import DropdownAction from '@/components/ReusableDatatable/dataTableDropdown.vue';
import Form from '@/components/ReusableForm/Form.vue';
import { currency } from '@/lib/utils';
import { destroy, pay } from '@/routes/debts';
import type { Debt } from '@/types';
import { details, inputs } from './index';

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
            const paid = !!row.original.paid_at;

            return h(paid ? Check : X, {
                class: paid ? 'h-4 w-4 text-green-500' : 'h-4 w-4 text-red-500',
            });
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
            const element = row.original as Debt;

            return h(
                'div',
                { class: 'relative' },
                h(
                    DropdownAction,
                    {
                        item: 'Debt',
                        payUrl: pay({ debt: element.id }).url,
                        deleteRoute: {
                            ...destroy({
                                debt: element.id,
                            }),
                            action: destroy({
                                debt: element.id,
                            }).url,
                        },
                    },
                    {
                        edit: () => h(Form, { inputs, details, element }),
                    },
                ),
            );
        },
    },
];
