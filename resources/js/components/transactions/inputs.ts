import FormCategorySelect from '../ReusableForm/inputs/FormCategorySelect.vue';
import FormInput from '../ReusableForm/inputs/FormInput.vue';

export const inputs = [
    {
        name: 'amount',
        type: 'number',
        label: 'Amount',
        placeholder: 'ex: 500$',
        component: FormInput,
    },
    {
        name: 'category_id',
        type: 'category-select',
        label: 'Category',
        placeholder: 'Select a category',
        getValue: (element?: any) => element?.category?.id,
        component: FormCategorySelect,
    },
    {
        name: 'description',
        type: 'text',
        label: 'Description',
        placeholder: 'ex: Salary for June',
        component: FormInput,
    },
];
