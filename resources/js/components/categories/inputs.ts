import FormInput from '../ReusableForm/inputs/FormInput.vue';
import FormSelect from '../ReusableForm/inputs/FormSelect.vue';

export const inputs = [
    {
        name: 'value',
        type: 'text',
        label: 'Value',
        placeholder: 'ex: Bills, Salary, etc.',
        component: FormInput,
    },
    {
        name: 'type',
        type: 'text',
        label: 'Type',
        placeholder: 'ex: Income, Expense',
        component: FormSelect,
        options: ['Income', 'Expense'],
    },
];
