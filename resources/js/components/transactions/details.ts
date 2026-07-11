import { store, update } from '@/routes/transactions';

export const details = {
    title: {
        store: 'Create Transaction',
        update: 'Update Transaction',
        description: 'Fill in the details to create a new transaction',
    },
    store: store,
    update: update,
    resourceKey: 'transaction',
};
