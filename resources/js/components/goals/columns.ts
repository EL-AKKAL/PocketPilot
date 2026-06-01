import type { ColumnDef } from '@tanstack/vue-table';
import { h } from 'vue';
import { currency, statusStyles } from '@/lib/utils';
import type { Goal } from '@/types';

export const columns: ColumnDef<Goal>[] = [
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
        accessorKey: 'Value',
        cell: ({ row }) => {
            return h(
                'div',
                { class: ' font-medium' },
                currency(row.original.value),
            );
        },
    },
    {
        accessorKey: 'Period',
        cell: ({ row }) => {
            const period = row.original.period;

            return h('div', { class: 'font-medium' }, period);
        },
    },
    {
        accessorKey: 'Type',
        cell: ({ row }) => {
            return h('div', { class: ' font-medium' }, row.original.type);
        },
    },
    {
        accessorKey: 'Status',
        cell: ({ row }) => {
            const status = row.original.status;

            return h(
                'span',
                {
                    class: [
                        'inline-flex items-center rounded-md px-2 py-1 text-xs font-medium',
                        statusStyles[status] ??
                            'bg-gray-100 text-gray-700 dark:bg-gray-500/10 dark:text-gray-300',
                    ],
                },
                status,
            );
        },
    },
];
