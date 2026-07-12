<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { reactive } from 'vue';
import FormDialog from '@/components/ReusableForm/FormDialog.vue';
import Checkbox from '@/components/ui/checkbox/Checkbox.vue';
import { starter_categories } from '@/routes/account/index.js';
import type { SuggestedCategories } from '@/types/index.js';
import AlertDialog from '../ui/alert-dialog/AlertDialog.vue';
import AlertDialogAction from '../ui/alert-dialog/AlertDialogAction.vue';
import AlertDialogCancel from '../ui/alert-dialog/AlertDialogCancel.vue';

const props = defineProps<{ suggestedCategories?: SuggestedCategories }>();

const open = ref(true);

const selected = reactive<Record<string, boolean>>({});

if (props.suggestedCategories) {
    for (const c of props.suggestedCategories?.income) {
        selected[c] = true;
    }

    for (const c of props.suggestedCategories?.expense) {
        selected[c] = true;
    }
}

function importCategories() {
    router.post(
        starter_categories().url,
        {
            income: props.suggestedCategories?.income.filter(
                (c) => selected[c],
            ),
            expense: props.suggestedCategories?.expense.filter(
                (c) => selected[c],
            ),
        },
        {
            onSuccess: () => (open.value = false),
        },
    );
}
</script>

<template>
    <AlertDialog :open="open">
        <FormDialog
            title="Starter Categories"
            description="Choose categories you would like to start with."
            v-if="
                suggestedCategories &&
                suggestedCategories.income &&
                suggestedCategories.expense
            "
        >
            <div>
                <h1>Income :</h1>
                <div
                    class="flex items-center gap-3"
                    v-for="category in suggestedCategories.income"
                    :key="category"
                >
                    <Checkbox v-model="selected[category]" />
                    <Label :for="category">{{ category }}</Label>
                </div>
            </div>

            <div>
                <h1>Expense :</h1>
                <div
                    class="flex items-center gap-3"
                    v-for="category in suggestedCategories.expense"
                    :key="category"
                >
                    <Checkbox v-model="selected[category]" />
                    <Label :for="category">{{ category }}</Label>
                </div>
            </div>
            <AlertDialogCancel @click="open = false">Skip</AlertDialogCancel>
            <AlertDialogAction @click="importCategories">
                Import Selected
            </AlertDialogAction>
        </FormDialog>
    </AlertDialog>
</template>
