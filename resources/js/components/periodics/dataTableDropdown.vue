<script setup lang="ts">
import { Form } from '@inertiajs/vue3'
import { MoreHorizontal } from 'lucide-vue-next'
import TransactionForm from '@/components/periodics/Form.vue';
import {
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
} from '@/components/ui/alert-dialog';
import { AlertDialog, AlertDialogTrigger } from '@/components/ui/alert-dialog';
import { Button } from '@/components/ui/button'
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator, DropdownMenuTrigger } from '@/components/ui/dropdown-menu'
import { destroy } from '@/routes/periodic_transactions';
import type { PeriodicTransaction } from '@/types';
defineProps<{
  periodic:PeriodicTransaction
}>()

</script>

<template>
  <DropdownMenu>
    <DropdownMenuTrigger as-child>
      <Button variant="ghost" class="w-8 h-8 p-0">
        <span class="sr-only">Open menu</span>
        <MoreHorizontal class="w-4 h-4" />
      </Button>
    </DropdownMenuTrigger>
    <DropdownMenuContent align="end">
      <DropdownMenuLabel>Actions</DropdownMenuLabel>
      <DropdownMenuItem @select.prevent>
                <AlertDialog>
                    <AlertDialogTrigger> Edit transaction </AlertDialogTrigger>
                    <TransactionForm :periodic="periodic" />
                </AlertDialog>
            </DropdownMenuItem>
      <DropdownMenuSeparator />
         <DropdownMenuItem @select.prevent>
                <AlertDialog>
                    <AlertDialogTrigger>Delete transaction</AlertDialogTrigger>
                    <AlertDialogContent>
                        <AlertDialogHeader>
                            <AlertDialogTitle
                                >Are you absolutely sure?</AlertDialogTitle
                            >
                            <AlertDialogDescription>
                                This action cannot be undone. This will
                                permanently delete the transaction.
                            </AlertDialogDescription>
                        </AlertDialogHeader>
                        <Form
                            v-bind="{
                                ...destroy({ periodic_transaction: periodic.id }),
                                action: destroy({
                                    periodic_transaction: periodic.id,
                                }).url,
                            }"
                            v-slot="{ processing }"
                            ><AlertDialogFooter>
                                <AlertDialogCancel>Cancel</AlertDialogCancel>
                                <AlertDialogAction
                                    type="submit"
                                    :disabled="processing"
                                >
                                    Continue
                                </AlertDialogAction>
                            </AlertDialogFooter>
                        </Form>
                    </AlertDialogContent>
                </AlertDialog>
            </DropdownMenuItem>
    </DropdownMenuContent>
  </DropdownMenu>
</template>
