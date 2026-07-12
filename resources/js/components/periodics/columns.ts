import type { ColumnDef } from '@tanstack/vue-table';
import { h } from 'vue';
import { details, inputs } from '@/components/periodics';
import DropdownAction from '@/components/ReusableDatatable/dataTableDropdown.vue';
import Form from '@/components/ReusableForm/Form.vue';
import { categoryStyles, currency } from '@/lib/utils';
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
            return h(
                'span',
                {
                    class: categoryStyles,
                },
                row.original.category?.value || 'No Category',
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
            const element = row.original as PeriodicTransaction;

            return h(
                'div',
                { class: 'relative' },
                h(
                    DropdownAction,
                    {
                        item: 'Periodic Transaction',
                        deleteRoute: {
                            ...destroy({
                                periodic_transaction: element.id,
                            }),
                            action: destroy({
                                periodic_transaction: element.id,
                            }).url,
                        },
                    },
                    {
                        edit: () => h(Form, { element, details, inputs }),
                    },
                ),
            );
        },
    },
];
