<script setup lang="ts">
import { Form } from '@inertiajs/vue3';
import FormDialog from '@/components/forms/FormDialog.vue';
import FormInput from '@/components/forms/FormInput.vue';
import FormSelect from '@/components/forms/FormSelect.vue';
import {
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogFooter,
} from '@/components/ui/alert-dialog';
import { Spinner } from '@/components/ui/spinner';
import { store, update } from '@/routes/categories';
import type { Category } from '@/types';

defineProps<{ category?: Category }>();
const types = ['Income', 'Expense'];
</script>

<template>
    <FormDialog
        :title="category ? 'Update your category' : 'New Category'"
        description="Fill in the details bellow to create or update a category."
    >
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
                <FormInput
                    label="Value"
                    name="value"
                    placeholder="ex: Bills, Salary, etc."
                    :default-value="category?.value"
                    required
                />
                <FormSelect
                    label="Type"
                    name="type"
                    :options="types"
                    :default-value="category?.type"
                />

                <AlertDialogFooter>
                    <AlertDialogCancel>Cancel</AlertDialogCancel>
                    <AlertDialogAction type="submit" :disabled="processing">
                        <Spinner v-if="processing" />
                        <span v-else>
                            {{ category ? 'Update' : 'Create' }}
                        </span>
                    </AlertDialogAction>
                </AlertDialogFooter>
            </div>
        </Form>
    </FormDialog>
</template>
