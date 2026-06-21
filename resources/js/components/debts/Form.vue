<script setup lang="ts">
import { Form } from '@inertiajs/vue3';
import FormDialog from '@/components/forms/FormDialog.vue';
import FormFooter from '@/components/forms/FormFooter.vue';
import FormInput from '@/components/forms/FormInput.vue';
import { store, update } from '@/routes/debts';
import type { Debt } from '@/types';

defineProps<{ debt?: Debt }>();
</script>

<template>
    <FormDialog
        :title="debt ? 'Update your debt' : 'New Debt'"
        description="Fill in the details bellow to create or update a debt."
    >
        <Form
            v-bind="
                debt
                    ? {
                          ...update({ debt: debt.id }),
                          action: update({ debt: debt.id }).url,
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
                    :default-value="debt?.amount"
                    required
                    min="0"
                    placeholder="ex: 500$"
                />

                <FormInput
                    label="Description"
                    name="description"
                    :default-value="debt?.description"
                    min="0"
                    placeholder="Description of the transaction"
                />

                <FormFooter :processing="processing" :entity="debt" />
            </div>
        </Form>
    </FormDialog>
</template>
