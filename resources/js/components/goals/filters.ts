import type { FilterDefinition } from '@/types';

export const filters: FilterDefinition[] = [
    {
        type: 'select',
        field: 'status',
        label: 'Status',
        options: [
            { label: 'In Progress', value: 'in_progress' },
            { label: 'Achieved', value: 'achieved' },
            { label: 'Failed', value: 'failed' },
        ],
    },
    {
        type: 'select',
        field: 'period',
        label: 'Period',
        options: [
            { label: 'Daily', value: 'daily' },
            { label: 'Weekly', value: 'weekly' },
            { label: 'Monthly', value: 'monthly' },
        ],
    },
    {
        type: 'select',
        field: 'type',
        label: 'Type',
        options: [
            { label: 'Savings', value: 'savings' },
            { label: 'Net', value: 'net' },
        ],
    },
];
