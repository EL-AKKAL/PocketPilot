<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { watchDebounced } from '@vueuse/core';
import { Search } from 'lucide-vue-next';
import { ref } from 'vue';
import { AlertDialog, AlertDialogTrigger } from '@/components/ui/alert-dialog';
import { Button } from '@/components/ui/button';
import Input from '@/components/ui/input/Input.vue';

const props = defineProps<{
    title: string;
    action: string | null;
    url: string;
}>();

const search = ref('');

watchDebounced(
    search,
    (value) => {
        router.get(
            props.url,
            { search: value },
            {
                preserveState: true,
                replace: true,
            },
        );
    },
    { debounce: 500, maxWait: 2000 },
);
</script>
<template>
    <div
        class="mx-auto flex w-full flex-col items-center justify-between gap-5 px-4 lg:flex-row"
    >
        <h2 class="text-2xl font-bold tracking-tight">
            {{ title }}
        </h2>
        <div class="flex items-center gap-4">
            <div class="relative">
                <Search
                    class="absolute top-[50%] left-2 h-4 w-4 translate-y-[-50%] text-muted-foreground"
                />
                <Input
                    v-model="search"
                    placeholder="Search..."
                    class="w-full pl-7 lg:w-64"
                />
            </div>

            <AlertDialog class="w-3xl!" v-if="action">
                <AlertDialogTrigger as-child>
                    <Button variant="outline" size="sm">{{ action }}</Button>
                </AlertDialogTrigger>
                <slot />
            </AlertDialog>
        </div>
    </div>
</template>
