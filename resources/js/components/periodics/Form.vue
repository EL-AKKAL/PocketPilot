<script setup lang="ts">
import { Form, usePage } from '@inertiajs/vue3';
import { getLocalTimeZone, today, parseDate } from '@internationalized/date';
import type { DateRange } from 'reka-ui';
import type { Ref } from 'vue';
import { ref } from 'vue';
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
import type { PeriodicTransaction } from '@/types';

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

const categories = usePage().props.categories;
</script>

<template>
    <AlertDialogContent class="max-w-xl!">
        <AlertDialogHeader>
            <AlertDialogTitle>New Transaction</AlertDialogTitle>
            <AlertDialogDescription>
                Fill in the details of the transaction you want to create, and
                click continue when you're done.
            </AlertDialogDescription>
        </AlertDialogHeader>
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
                        :default-value="periodic?.amount"
                        required
                        autofocus
                        :tabindex="1"
                        placeholder="500.00MAD"
                    />
                    <InputError :message="errors.amount" />
                </div>
                <div class="grid gap-2">
                    <div class="flex items-center justify-between">
                        <Label for="start_date">Category</Label>
                    </div>
                    <Select name="category" :default-value="periodic?.category">
                        <SelectTrigger class="w-full">
                            <SelectValue placeholder="Select a category" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectLabel>Categories</SelectLabel>
                                <SelectItem
                                    v-for="category in categories"
                                    :key="category"
                                    :value="category"
                                >
                                    {{ category }}
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
                        required
                        :default-value="periodic?.description"
                        :tabindex="2"
                        placeholder="Description of the transaction"
                    />
                    <InputError :message="errors.description" />
                </div>
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
                    <InputError :message="errors.start_date" />
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
                    <InputError :message="errors.frequency" />
                </div>
                <div class="grid gap-2">
                    <div class="flex items-center justify-between">
                        <Label for="start_date">Status</Label>
                    </div>
                    <Select
                        name="is_active"
                        :default-value="periodic?.is_active"
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
                    <InputError :message="errors.is_active" />
                </div>
                <AlertDialogFooter>
                    <AlertDialogCancel class="" :tabindex="2"
                        >Cancel</AlertDialogCancel
                    >
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
    </AlertDialogContent>
</template>
