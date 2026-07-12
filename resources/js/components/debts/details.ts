import { store, update } from '@/routes/debts';

export const details = {
    title: {
        store: 'Create Debt',
        update: 'Update Debt',
        description: 'Fill in the details to create a new debt',
    },
    store: store,
    update: update,
    resourceKey: 'debt',
};
