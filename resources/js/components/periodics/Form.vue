<script setup lang="ts">
import { Form } from '@inertiajs/vue3';
import { getLocalTimeZone, today, parseDate } from '@internationalized/date';
import type { DateRange } from 'reka-ui';
import type { Ref } from 'vue';
import { ref } from 'vue';
import FormCategorySelect from '@/components/forms/FormCategorySelect.vue';
import FormInput from '@/components/forms/FormInput.vue';
import {
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogFooter,
} from '@/components/ui/alert-dialog';
import { Label } from '@/components/ui/label';
import { RangeCalendar } from '@/components/ui/range-calendar';
import { Spinner } from '@/components/ui/spinner';
import { store, update } from '@/routes/periodic_transactions';
import type { PeriodicTransaction } from '@/types';
import FormDialog from '../forms/FormDialog.vue';
import FormSelect from '../forms/FormSelect.vue';

const props = defineProps<{
    periodic?: PeriodicTransaction;
}>();

const start = props.periodic?.start_date
    ? parseDate(props.periodic.start_date)
    : today(getLocalTimeZone());

const end = props.periodic?.end_date
    ? parseDate(props.periodic.end_date)
    : null;

const dateRange = ref({
    start,
    end,
}) as Ref<DateRange>;

const frequencies = [
    { label: 'Daily', value: 'daily' },
    { label: 'Weekly', value: 'weekly' },
    { label: 'Monthly', value: 'monthly' },
    { label: 'Yearly', value: 'yearly' },
];
const statusOptions = [
    { label: 'Active', value: 1 },
    { label: 'Inactive', value: 0 },
];
</script>

<template>
    <FormDialog
        class="max-w-xl!"
        :title="
            periodic
                ? 'Update periodic transaction'
                : 'New periodic transaction'
        "
        description="Fill in the details of the transaction you want to create or update, and click continue when you're done."
    >
        <Form
            v-bind="
                periodic
                    ? {
                          ...update({ periodic_transaction: periodic.id }),
                          action: update({ periodic_transaction: periodic.id })
                              .url,
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
                    :default-value="periodic?.amount"
                    required
                    min="-999999"
                    placeholder="ex: 500$"
                />
                <FormCategorySelect :id="periodic?.category?.id" />
                <FormInput
                    label="Description"
                    name="description"
                    :default-value="periodic?.description"
                    min="0"
                    placeholder="Description of the transaction"
                />
                <div class="grid gap-2">
                    <div class="flex items-center justify-between">
                        <Label for="start_date">Start Date - End Date</Label>
                    </div>
                    <RangeCalendar
                        v-model="dateRange"
                        class="w-full rounded-md border shadow-sm"
                        :number-of-months="2"
                        disable-days-outside-current-view
                    />
                </div>
                <FormSelect
                    label="Frequency"
                    name="frequency"
                    :options="frequencies"
                    :default-value="periodic?.frequency"
                    option-label="label"
                    option-value="value"
                />
                <FormSelect
                    label="Status"
                    name="is_active"
                    :options="statusOptions"
                    :default-value="periodic?.is_active ? 1 : 0"
                    option-label="label"
                    option-value="value"
                />
                <AlertDialogFooter>
                    <AlertDialogCancel>Cancel</AlertDialogCancel>
                    <AlertDialogAction
                        type="submit"
                        class=""
                        :disabled="processing"
                    >
                        <Spinner v-if="processing" />
                        <span v-else>Create</span></AlertDialogAction
                    >
                </AlertDialogFooter>
            </div>

            <input
                type="hidden"
                name="start_date"
                :value="
                    dateRange.start
                        ?.toDate(getLocalTimeZone())
                        .toISOString()
                        .slice(0, 10)
                "
            />

            <input
                type="hidden"
                name="end_date"
                :value="
                    dateRange.end
                        ?.toDate(getLocalTimeZone())
                        .toISOString()
                        .slice(0, 10)
                "
            />
        </Form>
    </FormDialog>
</template>
