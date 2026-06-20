import type { FilterDefinition } from '@/types';

export const filters: FilterDefinition[] = [
    {
        type: 'select',
        field: 'status',
        label: 'Status',
        options: [
            { label: 'Active', value: 'active' },
            { label: 'Inactive', value: 'inactive' },
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
];
