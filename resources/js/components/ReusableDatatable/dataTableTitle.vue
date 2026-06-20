<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { watchDebounced } from '@vueuse/core';
import { Search, SlidersHorizontal, ListFilterPlus } from 'lucide-vue-next';
import { reactive, ref } from 'vue';
import FormSelect from '@/components/forms/FormSelect.vue';
import { AlertDialog, AlertDialogTrigger } from '@/components/ui/alert-dialog';
import { Button } from '@/components/ui/button';
import Input from '@/components/ui/input/Input.vue';
import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from '@/components/ui/popover';
import type { FilterDefinition } from '@/types';

const props = defineProps<{
    title: string;
    action: string | null;
    url: string;
    filters?: FilterDefinition[];
}>();

const search = ref('');
const filterValues = reactive<Record<string, string | number | null>>({});

watchDebounced(
    () => ({ search: search.value, ...filterValues }),
    (params) => {
        router.get(props.url, params, {
            preserveState: true,
            replace: true,
        });
    },
    {
        debounce: 500,
    },
);

const clearFilters = () => {
    search.value = '';

    Object.keys(filterValues).forEach((key) => {
        delete filterValues[key];
    });

    router.get(
        props.url,
        {},
        {
            preserveState: true,
            replace: true,
        },
    );
};
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
            <Popover>
                <PopoverTrigger as-child>
                    <Button variant="outline">
                        <SlidersHorizontal class="h-4 w-4" />
                    </Button>
                    <Button
                        v-if="search || Object.keys(filterValues).length"
                        variant="ghost"
                        @click="clearFilters"
                    >
                        <ListFilterPlus class="h-4 w-4" />
                    </Button>
                </PopoverTrigger>
                <PopoverContent class="w-80">
                    <div class="grid gap-4">
                        <div class="space-y-2">
                            <h4 class="leading-none font-medium">Filters</h4>
                            <p class="text-sm text-muted-foreground">
                                choose your filters.
                            </p>
                        </div>
                        <div
                            class="grid gap-2"
                            v-for="filter in filters"
                            :key="filter.field"
                        >
                            <FormSelect
                                v-if="filter.type === 'select'"
                                :label="filter.label"
                                name="filter"
                                :options="filter.options"
                                optionLabel="label"
                                optionValue="value"
                                v-model="filterValues[filter.field]"
                            />
                        </div>
                    </div>
                </PopoverContent>
            </Popover>
            <AlertDialog class="w-3xl!" v-if="action">
                <AlertDialogTrigger as-child>
                    <Button variant="outline" size="sm">{{ action }}</Button>
                </AlertDialogTrigger>
                <slot />
            </AlertDialog>
        </div>
    </div>
</template>
