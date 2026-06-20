import type { FilterDefinition } from '@/types';

export const filters: FilterDefinition[] = [
    {
        type: 'select',
        field: 'is_active',
        label: 'Status',
        options: [
            { label: 'Active', value: '1' },
            { label: 'Inactive', value: '0' },
        ],
    },
    {
        type: 'select',
        field: 'frequency',
        label: 'Frequency',
        options: [
            { label: 'Daily', value: 'daily' },
            { label: 'Weekly', value: 'weekly' },
            { label: 'Monthly', value: 'monthly' },
        ],
    },
];
