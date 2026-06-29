<script setup lang="ts">
import { Form } from '@inertiajs/vue3';
import { getLocalTimeZone, today, parseDate } from '@internationalized/date';
import type { DateValue } from '@internationalized/date';
import { ref } from 'vue';
import type { Ref } from 'vue';
import FormDialog from '@/components/forms/FormDialog.vue';
import FormFooter from '@/components/forms/FormFooter.vue';
import FormInput from '@/components/forms/FormInput.vue';
import { Calendar } from '@/components/ui/calendar';
import { store, update } from '@/routes/debts';
import type { Debt } from '@/types';

const props = defineProps<{ debt?: Debt }>();

const dueDate = ref(
    props.debt?.due_date
        ? parseDate(props.debt.due_date)
        : today(getLocalTimeZone()),
) as Ref<DateValue>;
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

                <div class="grid gap-2">
                    <div class="flex items-center justify-between">
                        <Label for="due_date">Due Date</Label>
                    </div>
                    <Calendar
                        v-model="dueDate"
                        class="w-full rounded-md border shadow-sm"
                    />
                    <input
                        type="hidden"
                        name="due_date"
                        :value="
                            dueDate
                                ?.toDate(getLocalTimeZone())
                                .toISOString()
                                .slice(0, 10)
                        "
                    />
                </div>

                <FormFooter :processing="processing" :entity="debt" />
            </div>
        </Form>
    </FormDialog>
</template>
