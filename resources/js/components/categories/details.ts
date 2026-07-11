import { store, update } from '@/routes/categories';

export const details = {
    title: {
        store: 'Create Category',
        update: 'Update Category',
        description: 'Fill in the details to create a new category',
    },
    store: store,
    update: update,
    resourceKey: 'category',
};
