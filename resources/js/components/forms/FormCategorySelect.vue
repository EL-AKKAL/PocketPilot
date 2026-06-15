<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
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
import type { Categories } from '@/types';

defineProps<{ id?: number }>();
const categories = usePage().props.categories as Categories;
</script>

<template>
    <div class="grid gap-2">
        <div class="flex items-center justify-between">
            <Label for="category_id">Category</Label>
        </div>
        <Select name="category_id" :default-value="id">
            <SelectTrigger class="w-full">
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
</template>
