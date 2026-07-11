import type { ColumnDef } from '@tanstack/vue-table';
import { h } from 'vue';
import DropdownAction from '@/components/ReusableDatatable/dataTableDropdown.vue';
import Form from '@/components/ReusableForm/Form.vue';
import { destroy } from '@/routes/categories';
import type { Category } from '@/types';
import { details, inputs } from './index';

export const columns: ColumnDef<Category>[] = [
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
            return h('div', { class: ' font-medium' }, row.original.value);
        },
    },
    {
        accessorKey: 'Type',
        cell: ({ row }) => {
            return h('div', { class: ' font-medium' }, row.original.type);
        },
    },
    {
        id: 'actions',
        accessorKey: 'actions',
        cell: ({ row }) => {
            const category = row.original as Category;

            return h(
                'div',
                { class: 'relative' },
                h(
                    DropdownAction,
                    {
                        item: 'Category',
                        deleteRoute: {
                            ...destroy({
                                category: category.id,
                            }),
                            action: destroy({
                                category: category.id,
                            }).url,
                        },
                    },
                    {
                        edit: () =>
                            h(Form, {
                                inputs: inputs,
                                details: details,
                                resourceKey: 'category',
                                element: category,
                            }),
                    },
                ),
            );
        },
    },
];
