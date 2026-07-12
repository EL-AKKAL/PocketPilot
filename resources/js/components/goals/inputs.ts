import { usePage } from '@inertiajs/vue3';
import FormInput from '../ReusableForm/inputs/FormInput.vue';
import FormSelect from '../ReusableForm/inputs/FormSelect.vue';

export const inputs = [
    {
        name: 'value',
        type: 'number',
        label: 'Value',
        placeholder: 'ex: 100, 200, etc.',
        component: FormInput,
    },
    {
        name: 'type',
        type: 'select',
        label: 'Type',
        component: FormSelect,
        getOptions: () => usePage().props.goalTypes as string[],
    },
    {
        name: 'period',
        type: 'select',
        label: 'Period',
        component: FormSelect,
        getOptions: () => usePage().props.goalPeriods as string[],
    },
];
