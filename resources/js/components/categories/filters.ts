import type { FilterDefinition } from '@/types';

export const filters: FilterDefinition[] = [
    {
        type: 'select',
        field: 'type',
        label: 'Type',
        options: [
            { label: 'Income', value: 'income' },
            { label: 'Expense', value: 'expense' },
        ],
    },
];
