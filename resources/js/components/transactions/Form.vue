<script setup lang="ts">
import { Form } from '@inertiajs/vue3';
import FormCategorySelect from '@/components/forms/FormCategorySelect.vue';
import FormDialog from '@/components/forms/FormDialog.vue';
import FormInput from '@/components/forms/FormInput.vue';
import {
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogFooter,
} from '@/components/ui/alert-dialog';
import { Spinner } from '@/components/ui/spinner';
import { store, update } from '@/routes/transactions';
import type { Transaction } from '@/types';

defineProps<{
    transaction?: Transaction;
}>();
</script>

<template>
    <FormDialog
        :title="transaction ? 'Update your transaction' : 'New Transaction'"
        description="Fill in the details bellow to create or update a transaction."
    >
        <Form
            v-bind="
                transaction
                    ? {
                          ...update({ transaction: transaction.id }),
                          action: update({ transaction: transaction.id }).url,
                      }
                    : store.form()
            "
            :reset-on-success="['amount', 'description']"
            v-slot="{ processing }"
            class="flex flex-col gap-6"
        >
            <div class="grid gap-6">
                <FormInput
                    label="Amount"
                    name="amount"
                    type="number"
                    :default-value="transaction?.amount"
                    required
                    min="-999999"
                    placeholder="ex: 500$"
                />
                <FormCategorySelect :id="transaction?.category?.id" />

                <FormInput
                    label="Description"
                    name="description"
                    :default-value="transaction?.description"
                    min="0"
                    placeholder="Description of the transaction"
                />

                <AlertDialogFooter>
                    <AlertDialogCancel :tabindex="4">Cancel</AlertDialogCancel>
                    <AlertDialogAction
                        :tabindex="5"
                        type="submit"
                        :disabled="processing"
                    >
                        <Spinner v-if="processing" />
                        <span v-else>
                            {{ transaction ? 'Update' : 'Create' }}
                        </span>
                    </AlertDialogAction>
                </AlertDialogFooter>
            </div>
        </Form>
    </FormDialog>
</template>
