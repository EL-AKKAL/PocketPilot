import { store, update } from '@/routes/goals';

export const details = {
    title: {
        store: 'Create Goal',
        update: 'Update Goal',
        description: 'Fill in the details to create a new goal',
    },
    store: store,
    update: update,
    resourceKey: 'goal',
};
