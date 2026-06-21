import type { ColumnDef } from '@tanstack/vue-table';
import { Check, X } from 'lucide-vue-next';
import { h } from 'vue';
import Form from '@/components/debts/Form.vue';
import DropdownAction from '@/components/ReusableDatatable/dataTableDropdown.vue';
import { currency } from '@/lib/utils';
import { destroy, pay } from '@/routes/debts';
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
            const debt = row.original as Debt;

            return h(
                'div',
                { class: 'relative' },
                h(
                    DropdownAction,
                    {
                        item: 'Debt',
                        payUrl: pay({ debt: debt.id }).url,
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
