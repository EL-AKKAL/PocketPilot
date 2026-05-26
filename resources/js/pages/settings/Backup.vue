<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { Form } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';
import { edit } from '@/routes/appearance';
import backup from '@/routes/backup';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Appearance settings',
                href: edit(),
            },
        ],
    },
});

const downloadBackup = () => (window.location.href = backup.export().url);
</script>

<template>
    <Head title="Data & Backup" />
    <div class="space-y-6">
        <!-- IMPORT -->
        <Heading
            variant="small"
            title="Data management settings"
            description="Here you can download or restore your data from a backup file."
        />

        <div
            class="w-lg space-y-4 rounded-lg border border-red-100 bg-red-50 p-4 dark:border-red-200/10 dark:bg-red-700/10"
        >
            <div class="space-y-0.5 text-red-600 dark:text-red-100">
                <p class="font-medium">Important</p>
                <p class="text-sm">
                    This will replace all your current data. Only import files
                    previously exported from PocketPilot (JSON format).
                </p>
            </div>

            <Dialog>
                <DialogTrigger as-child>
                    <Button variant="destructive">Import data</Button>
                </DialogTrigger>

                <DialogContent>
                    <Form
                        reset-on-success
                        :options="{ preserveScroll: true }"
                        class="space-y-6"
                        v-slot="{ processing, reset, clearErrors }"
                    >
                        <DialogHeader class="space-y-3">
                            <DialogTitle> Import backup data </DialogTitle>
                            <DialogDescription>
                                Your current data will be permanently replaced
                                by the imported file. This action cannot be
                                undone.
                            </DialogDescription>
                        </DialogHeader>

                        <DialogFooter class="gap-2">
                            <DialogClose as-child>
                                <Button
                                    variant="secondary"
                                    @click="
                                        () => {
                                            clearErrors();
                                            reset();
                                        }
                                    "
                                >
                                    Cancel
                                </Button>
                            </DialogClose>

                            <Button
                                type="submit"
                                variant="destructive"
                                :disabled="processing"
                            >
                                Confirm import
                            </Button>
                        </DialogFooter>
                    </Form>
                </DialogContent>
            </Dialog>
        </div>
        <div
            class="w-lg space-y-6 rounded-lg border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-800"
        >
            <div class="space-y-4 text-gray-700 dark:text-gray-200">
                <div class="space-y-0.5">
                    <p class="font-medium">Backup recommended</p>
                    <p class="text-sm">
                        Export your data regularly to keep a safe copy on your
                        device.
                    </p>
                </div>
                <Button @click="downloadBackup"> Download backup </Button>
            </div>
        </div>
    </div>
</template>
