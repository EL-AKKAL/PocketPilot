import FormCategorySelect from '../ReusableForm/inputs/FormCategorySelect.vue';
import FormDateRange from '../ReusableForm/inputs/FormDateRange.vue';
import FormInput from '../ReusableForm/inputs/FormInput.vue';
import FormSelect from '../ReusableForm/inputs/FormSelect.vue';

const frequencies = [
    { label: 'Daily', value: 'daily' },
    { label: 'Weekly', value: 'weekly' },
    { label: 'Monthly', value: 'monthly' },
    { label: 'Yearly', value: 'yearly' },
];
const statusOptions = [
    { label: 'Active', value: 1 },
    { label: 'Inactive', value: 0 },
];
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
    {
        component: FormDateRange,
        label: 'Start Date - End Date',
        name: 'date_range',
        type: 'date-range',
        startName: 'start_date',
        endName: 'end_date',
        getStartValue: (element?: any) => element?.start_date as any,
        getEndValue: (element?: any) => element?.end_date as any,
    },
    {
        name: 'frequency',
        type: 'select',
        label: 'Frequency',
        placeholder: 'Select a frequency',
        options: frequencies,
        component: FormSelect,
        optionLabel: 'label',
        optionValue: 'value',
    },
    {
        name: 'is_active',
        type: 'select',
        label: 'Status',
        placeholder: 'Select a status',
        options: statusOptions,
        component: FormSelect,
        optionLabel: 'label',
        optionValue: 'value',
    },
];
