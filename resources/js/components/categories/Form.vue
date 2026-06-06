<script setup lang="ts">
import { Form } from '@inertiajs/vue3';
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
import { store, update } from '@/routes/categories';
import type { Category } from '@/types';

defineProps<{
    category?: Category;
}>();
</script>

<template>
    <AlertDialogContent>
        <AlertDialogHeader>
            <AlertDialogTitle
                >{{ category ? 'Update' : 'New' }} Category</AlertDialogTitle
            >
            <AlertDialogDescription>
                Fill in the details of the category you want to
                {{ category ? 'update' : 'create' }}, and click continue when
                you're done.
            </AlertDialogDescription>
        </AlertDialogHeader>

        <Form
            v-bind="
                category
                    ? {
                          ...update({ category: category.id }),
                          action: update({ category: category.id }).url,
                      }
                    : store.form()
            "
            :reset-on-success="['value', 'type']"
            v-slot="{ processing }"
            class="flex flex-col gap-6"
        >
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label for="value">Value</Label>
                    <Input
                        id="value"
                        name="value"
                        autofocus
                        :default-value="category?.value"
                        required
                        :tabindex="1"
                        placeholder="ex: Bills, Salary, etc."
                    />
                </div>
                <div class="grid gap-2">
                    <div class="flex items-center justify-between">
                        <Label for="type">Type</Label>
                    </div>
                    <Select
                        id="type"
                        name="type"
                        :default-value="category?.type"
                    >
                        <SelectTrigger class="w-full" :tabindex="2">
                            <SelectValue placeholder="Select a type" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectLabel>Type</SelectLabel>
                                <SelectItem
                                    v-for="type in ['Income', 'Expense']"
                                    :key="type"
                                    :value="type"
                                >
                                    {{ type }}
                                </SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>
                </div>

                <AlertDialogFooter>
                    <AlertDialogCancel :tabindex="4">Cancel</AlertDialogCancel>
                    <AlertDialogAction
                        :tabindex="5"
                        type="submit"
                        :disabled="processing"
                    >
                        <Spinner v-if="processing" />
                        <span v-else>
                            {{ category ? 'Update' : 'Create' }}
                        </span>
                    </AlertDialogAction>
                </AlertDialogFooter>
            </div>
        </Form>
    </AlertDialogContent>
</template>
