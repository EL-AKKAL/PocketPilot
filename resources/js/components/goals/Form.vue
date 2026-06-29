<script setup lang="ts">
import { Form, usePage } from '@inertiajs/vue3';
import FormDialog from '@/components/forms/FormDialog.vue';
import FormFooter from '@/components/forms/FormFooter.vue';
import FormInput from '@/components/forms/FormInput.vue';
import FormSelect from '@/components/forms/FormSelect.vue';
import { store, update } from '@/routes/goals';
import type { GoalStatistic } from '@/types';

defineProps<{ goal?: GoalStatistic }>();

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
                    min="0"
                    placeholder="ex: 500$"
                />
                <FormSelect
                    label="Type"
                    name="type"
                    :options="types"
                    :default-value="goal?.type"
                />
                <FormSelect
                    label="Period"
                    name="period"
                    :options="periods"
                    :default-value="goal?.period"
                />

                <FormFooter :processing="processing" :entity="goal" />
            </div>
        </Form>
    </FormDialog>
</template>
