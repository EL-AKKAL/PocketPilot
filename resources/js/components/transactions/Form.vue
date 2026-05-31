<script setup lang="ts">
import { Form, usePage } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import {
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
} from '@/components/ui/alert-dialog';
import { Input } from '@/components/ui/input';
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
import type { Category, Transaction } from '@/types';

defineProps<{
    transaction?: Transaction;
}>();

const categories = usePage().props.categories as Category;
</script>

<template>
    <AlertDialogContent>
        <AlertDialogHeader>
            <AlertDialogTitle>New Transaction</AlertDialogTitle>
            <AlertDialogDescription>
                Fill in the details of the transaction you want to create, and
                click continue when you're done.
            </AlertDialogDescription>
        </AlertDialogHeader>

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
            v-slot="{ errors, processing }"
            class="flex flex-col gap-6"
        >
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label for="amount">Amount</Label>
                    <Input
                        id="amount"
                        type="number"
                        name="amount"
                        :default-value="transaction?.amount"
                        required
                        autofocus
                        :tabindex="1"
                        placeholder="500.00MAD"
                    />
                    <InputError :message="errors.amount" />
                </div>
                <div class="grid gap-2">
                    <div class="flex items-center justify-between">
                        <Label for="category">Category</Label>
                    </div>
                    <Select
                        name="category"
                        :default-value="transaction?.category"
                    >
                        <SelectTrigger class="w-full">
                            <SelectValue placeholder="Select a category" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectLabel>Income</SelectLabel>
                                <SelectItem
                                    v-for="income in categories.income"
                                    :key="income"
                                    :value="income"
                                >
                                    {{ income }}
                                </SelectItem>
                            </SelectGroup>
                            <SelectGroup>
                                <SelectLabel>Expense</SelectLabel>
                                <SelectItem
                                    v-for="expense in categories.expense"
                                    :key="expense"
                                    :value="expense"
                                >
                                    {{ expense }}
                                </SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>
                    <InputError :message="errors.category" />
                </div>

                <div class="grid gap-2">
                    <div class="flex items-center justify-between">
                        <Label for="description">Description</Label>
                    </div>
                    <Input
                        id="description"
                        name="description"
                        :tabindex="2"
                        :default-value="transaction?.description"
                        placeholder="Description of the transaction"
                    />
                    <InputError :message="errors.description" />
                </div>

                <AlertDialogFooter>
                    <AlertDialogCancel :tabindex="2">Cancel</AlertDialogCancel>
                    <AlertDialogAction type="submit" :disabled="processing">
                        <Spinner v-if="processing" />
                        <span v-else>
                            {{ transaction ? 'Update' : 'Create' }}
                        </span>
                    </AlertDialogAction>
                </AlertDialogFooter>
            </div>
        </Form>
    </AlertDialogContent>
</template>
