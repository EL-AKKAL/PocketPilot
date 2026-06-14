<script setup lang="ts">
import { Form, usePage } from '@inertiajs/vue3';
import { getLocalTimeZone, today, parseDate } from '@internationalized/date';
import type { DateRange } from 'reka-ui';
import type { Ref } from 'vue';
import { ref } from 'vue';
import FormInput from '@/components/forms/FormInput.vue';
import {
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogFooter,
} from '@/components/ui/alert-dialog';
import { Label } from '@/components/ui/label';
import { RangeCalendar } from '@/components/ui/range-calendar';
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
import { store, update } from '@/routes/periodic_transactions';
import type { Categories, PeriodicTransaction } from '@/types';
import FormDialog from '../forms/FormDialog.vue';

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

const categories = usePage().props.categories as Categories;
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
                    min="0"
                    placeholder="ex: 500$"
                />
                <div class="grid gap-2">
                    <div class="flex items-center justify-between">
                        <Label for="category_id">Category</Label>
                    </div>
                    <Select
                        name="category_id"
                        :default-value="periodic?.category?.id"
                    >
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
                <div class="grid gap-2">
                    <div class="flex items-center justify-between">
                        <Label for="start_date">Frequency</Label>
                    </div>
                    <Select
                        name="frequency"
                        :default-value="periodic?.frequency"
                    >
                        <SelectTrigger class="w-full">
                            <SelectValue placeholder="Select a frequency" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectLabel>Frequencies</SelectLabel>
                                <SelectItem value="daily"> Daily </SelectItem>
                                <SelectItem value="weekly"> Weekly </SelectItem>
                                <SelectItem value="monthly">
                                    Monthly
                                </SelectItem>
                                <SelectItem value="yearly"> Yearly </SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>
                </div>
                <div class="grid gap-2">
                    <div class="flex items-center justify-between">
                        <Label for="is_active">Status</Label>
                    </div>
                    <Select
                        name="is_active"
                        :default-value="periodic?.is_active ? 1 : 0"
                    >
                        <SelectTrigger class="w-full">
                            <SelectValue placeholder="Select a status" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectLabel>Status</SelectLabel>
                                <SelectItem :value="1"> Active </SelectItem>
                                <SelectItem :value="0"> Inactive </SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>
                </div>
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
