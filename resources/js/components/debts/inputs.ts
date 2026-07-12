import FormDate from '../ReusableForm/inputs/FormDate.vue';
import FormInput from '../ReusableForm/inputs/FormInput.vue';

export const inputs = [
    {
        name: 'amount',
        type: 'number',
        label: 'Amount',
        placeholder: 'ex: 100, 200, etc.',
        component: FormInput,
    },
    {
        name: 'description',
        type: 'text',
        label: 'Description',
        placeholder: 'ex: debt from John.',
        component: FormInput,
    },
    {
        name: 'due_date',
        type: 'date',
        label: 'Due Date',
        component: FormDate,
    },
];
