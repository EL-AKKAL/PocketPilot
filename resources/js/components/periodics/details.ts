import { store, update } from '@/routes/periodic_transactions';

export const details = {
    title: {
        store: 'Create Periodic Transaction',
        update: 'Update Periodic Transaction',
        description: 'Fill in the details to create a new periodic transaction',
    },
    store: store,
    update: update,
    resourceKey: 'periodic_transaction',
};
