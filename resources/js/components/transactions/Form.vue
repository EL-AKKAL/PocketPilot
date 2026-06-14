<script setup lang="ts">
import { Form, usePage } from '@inertiajs/vue3';
import FormDialog from '@/components/forms/FormDialog.vue';
import FormInput from '@/components/forms/FormInput.vue';
import {
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogFooter,
} from '@/components/ui/alert-dialog';
import { Label } from '@/components/ui/label';
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { Spinner } from '@/components/ui/spinner';
import { store, update } from '@/routes/transactions';
import type { Categories, Transaction } from '@/types';

defineProps<{
    transaction?: Transaction;
}>();

const categories = usePage().props.categories as Categories;
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
                    min="0"
                    placeholder="ex: 500$"
                />
                <div class="grid gap-2">
                    <div class="flex items-center justify-between">
                        <Label for="category">Category</Label>
                    </div>
                    <Select
                        name="category_id"
                        :default-value="transaction?.category?.id"
                    >
                        <SelectTrigger class="w-full" :tabindex="2">
                            <SelectValue placeholder="Select a category" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectLabel>Income</SelectLabel>
                                <SelectItem
                                    v-for="income in categories.income"
                                    :key="income.id"
                                    :value="income.id"
                                >
                                    {{ income.value }}
                                </SelectItem>
                            </SelectGroup>
                            <SelectGroup>
                                <SelectLabel>Expense</SelectLabel>
                                <SelectItem
                                    v-for="expense in categories.expense"
                                    :key="expense.id"
                                    :value="expense.id"
                                >
                                    {{ expense.value }}
                                </SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>
                </div>

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
