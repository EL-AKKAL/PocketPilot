<script setup lang="ts">
import { Pen, Plus } from 'lucide-vue-next';
import Form from '@/components/goals/Form.vue';
import { AlertDialog, AlertDialogTrigger } from '@/components/ui/alert-dialog';
import Button from '@/components/ui/button/Button.vue';
import { Card, CardContent } from '@/components/ui/card';
import type { GoalStatistic } from '@/types';
defineProps<{
    goal: GoalStatistic;
    canCreateGoal: boolean;
}>();
</script>

<template>
    <Card class="shadow-none">
        <CardContent>
            <div v-if="goal">
                <div class="space-y-4 rounded-xl">
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
                                'bg-green-100 text-green-700':
                                    goal.status === 'achieved',
                                'bg-red-100 text-red-700':
                                    goal.status === 'failed',
                            }"
                        >
                            {{ goal.status }}
                        </span>
                    </div>

                    <!-- Progress -->
                    <div class="space-y-1">
                        <p class="text-sm">
                            {{ goal.progress.toFixed(2) }} /
                            {{ goal.value }} MAD
                        </p>

                        <div class="h-2 w-full rounded bg-accent">
                            <div
                                class="h-2 rounded bg-primary transition-all"
                                :style="{
                                    width: Math.min(goal.percentage, 100) + '%',
                                }"
                            />
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="flex w-full items-center justify-between">
                        <p class="text-xs text-gray-400">
                            Ends at
                            {{ new Date(goal.ends_at).toLocaleDateString() }}
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
            </div>

            <div
                v-else-if="canCreateGoal"
                class="flex w-full items-center justify-between"
            >
                No active goal.
                <AlertDialog class="w-3xl!">
                    <AlertDialogTrigger as-child>
                        <Button
                            size="icon-sm"
                            variant="outline"
                            class="rounded-full"
                        >
                            <Plus class="h-5 w-5" />
                        </Button>
                    </AlertDialogTrigger>
                    <GoalForm />
                </AlertDialog>
            </div>
        </CardContent>
    </Card>
</template>
