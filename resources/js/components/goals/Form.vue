<script setup lang="ts">
import { Form, usePage } from '@inertiajs/vue3';
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
import { store, update } from '@/routes/goals';
import type { GoalStatistic } from '@/types';

defineProps<{
    goal?: GoalStatistic;
}>();

const periods = usePage().props.goalPeriods as string[];
const types = usePage().props.goalTypes as string[];
</script>

<template>
    <AlertDialogContent>
        <AlertDialogHeader>
            <AlertDialogTitle>{{
                goal ? 'Update your goal' : 'New Goal'
            }}</AlertDialogTitle>
            <AlertDialogDescription>
                Fill in the details of the goal you want to create, and click
                continue when you're done.
            </AlertDialogDescription>
        </AlertDialogHeader>

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
            v-slot="{ errors, processing }"
            class="flex flex-col gap-6"
        >
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label for="value">Value</Label>
                    <Input
                        id="value"
                        type="number"
                        name="value"
                        :default-value="goal?.value"
                        required
                        autofocus
                        min="0"
                        :tabindex="1"
                        placeholder="ex: 500$"
                    />
                </div>
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
                        :disabled="goal"
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
                    <AlertDialogCancel :tabindex="2">Cancel</AlertDialogCancel>
                    <AlertDialogAction type="submit" :disabled="processing">
                        <Spinner v-if="processing" />
                        <span v-else>{{
                            goal ? 'Update' : 'Create'
                        }}</span></AlertDialogAction
                    >
                </AlertDialogFooter>
            </div>
        </Form>
    </AlertDialogContent>
</template>
