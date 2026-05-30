<script setup lang="ts">
import { Pen, Plus } from 'lucide-vue-next';
import { AlertDialog, AlertDialogTrigger } from '@/components/ui/alert-dialog';
import type { GoalStatistic } from '@/types';
import Button from '../ui/button/Button.vue';
import Form from './Form.vue';

defineProps<{
    goal: GoalStatistic;
}>();
</script>

<template>
    <div class="space-y-4 rounded-xl bg-white dark:bg-gray-900">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold">
                {{ goal.period }} Goal ({{ goal.type }})
            </h3>
            <span
                class="rounded px-2 py-1 text-xs"
                :class="{
                    'bg-yellow-100 text-yellow-700':
                        goal.status === 'in_progress',
                    'bg-green-100 text-green-700': goal.status === 'achieved',
                    'bg-red-100 text-red-700': goal.status === 'failed',
                }"
            >
                {{ goal.status }}
            </span>
        </div>

        <!-- Progress -->
        <div class="space-y-1">
            <p class="text-sm text-gray-500">
                {{ goal.progress.toFixed(2) }} / {{ goal.value }} MAD
            </p>

            <div class="h-2 w-full rounded bg-gray-200">
                <div
                    class="h-2 rounded bg-blue-500 transition-all"
                    :style="{ width: Math.min(goal.percentage, 100) + '%' }"
                />
            </div>
        </div>

        <!-- Footer -->
        <div class="flex w-full items-center justify-between">
            <p class="text-xs text-gray-400">
                Ends at {{ new Date(goal.ends_at).toLocaleDateString() }}
            </p>
            <div class="flex items-center gap-3">
                <AlertDialog class="w-3xl!">
                    <AlertDialogTrigger as-child>
                        <Button
                            size="icon-sm"
                            variant="outline"
                            class="rounded-full"
                        >
                            <Pen class="h-3 w-3!" />
                        </Button>
                    </AlertDialogTrigger>
                    <Form :goal />
                </AlertDialog>
                <AlertDialog class="w-3xl!">
                    <AlertDialogTrigger as-child>
                        <Button
                            size="icon-sm"
                            variant="outline"
                            class="rounded-full"
                        >
                            <Plus class="h-3 w-3!" />
                        </Button>
                    </AlertDialogTrigger>
                    <Form />
                </AlertDialog>
            </div>
        </div>
    </div>
</template>
