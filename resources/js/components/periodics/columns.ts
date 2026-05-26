import type { ColumnDef } from '@tanstack/vue-table';
import { h } from 'vue';
import Form from '@/components/periodics/Form.vue';
import DropdownAction from '@/components/ReusableDatatable/dataTableDropdown.vue';
import { categoryStyles } from '@/lib/utils';
import { destroy } from '@/routes/periodic_transactions';
import type { PeriodicTransaction } from '@/types';

export const columns: ColumnDef<PeriodicTransaction>[] = [
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
                        'inline-flex items-center rounded-md px-2 py-1 text-xs font-medium',
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
        accessorKey: 'Start at',
        cell: ({ row }) => {
            return h('div', { class: ' font-medium' }, row.original.start_date);
        },
    },
    {
        accessorKey: 'End at',
        cell: ({ row }) => {
            return h('div', { class: ' font-medium' }, row.original.end_date);
        },
    },
    {
        accessorKey: 'Frequency',
        cell: ({ row }) => {
            return h('div', { class: ' font-medium' }, row.original.frequency);
        },
    },
    {
        accessorKey: 'Next Apply Date',
        cell: ({ row }) => {
            return h(
                'div',
                { class: ' font-medium' },
                row.original.next_apply_date,
            );
        },
    },
    {
        accessorKey: 'Status',
        cell: ({ row }) => {
            return h(
                'div',
                { class: ' font-medium' },
                row.original.is_active ? 'Active' : 'Inactive',
            );
        },
    },
    {
        id: 'actions',
        accessorKey: 'actions',
        cell: ({ row }) => {
            const periodic = row.original as PeriodicTransaction;

            return h(
                'div',
                { class: 'relative' },
                h(
                    DropdownAction,
                    {
                        item: 'Periodic Transaction',
                        deleteRoute: {
                            ...destroy({
                                periodic_transaction: periodic.id,
                            }),
                            action: destroy({
                                periodic_transaction: periodic.id,
                            }).url,
                        },
                    },
                    {
                        edit: () =>
                            h(Form, {
                                periodic,
                            }),
                    },
                ),
            );
        },
    },
];
