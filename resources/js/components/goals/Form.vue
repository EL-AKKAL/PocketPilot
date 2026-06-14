<script setup lang="ts">
import { Form, usePage } from '@inertiajs/vue3';
import FormDialog from '@/components/forms/FormDialog.vue';
import FormInput from '@/components/forms/FormInput.vue';
import {
    AlertDialogCancel,
    AlertDialogAction,
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
import { store, update } from '@/routes/goals';
import type { GoalStatistic } from '@/types';

defineProps<{
    goal?: GoalStatistic;
}>();

const periods = usePage().props.goalPeriods as string[];
const types = usePage().props.goalTypes as string[];
</script>

<template>
    <FormDialog
        :title="goal ? 'Update your goal' : 'New Goal'"
        description="Fill in the details bellow to create or update a goal."
    >
        <Form
            v-bind="
                goal
                    ? {
                          ...update({ goal: goal.id }),
                          action: update({ goal: goal.id }).url,
                      }
                    : store.form()
            "
            :reset-on-success="['value']"
            v-slot="{ processing }"
            class="flex flex-col gap-6"
        >
            <div class="grid gap-6">
                <FormInput
                    label="Value"
                    name="value"
                    type="number"
                    :default-value="goal?.value"
                    required
                    min="0"
                    placeholder="ex: 500$"
                />
                <div class="grid gap-2">
                    <div class="flex items-center justify-between">
                        <Label for="start_date">Type</Label>
                    </div>
                    <Select name="type" :default-value="goal?.type">
                        <SelectTrigger class="w-full">
                            <SelectValue placeholder="Select a type" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectLabel>Types</SelectLabel>
                                <SelectItem
                                    v-for="type in types"
                                    :key="type"
                                    :value="type"
                                >
                                    {{ type }}
                                </SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>
                </div>
                <div class="grid gap-2">
                    <div class="flex items-center justify-between">
                        <Label for="start_date">Period</Label>
                    </div>
                    <Select
                        name="period"
                        :disabled="!!goal"
                        :default-value="goal?.period"
                    >
                        <SelectTrigger class="w-full">
                            <SelectValue placeholder="Select a period" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectLabel>Periods</SelectLabel>
                                <SelectItem
                                    v-for="period in periods"
                                    :key="period"
                                    :value="period"
                                >
                                    {{ period }}
                                </SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>
                </div>

                <AlertDialogFooter>
                    <AlertDialogCancel> Cancel </AlertDialogCancel>
                    <AlertDialogAction type="submit" :disabled="processing">
                        <Spinner v-if="processing" />
                        <span v-else>
                            {{ goal ? 'Update' : 'Create' }}
                        </span>
                    </AlertDialogAction>
                </AlertDialogFooter>
            </div>
        </Form>
    </FormDialog>
</template>
