<script setup lang="ts">
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
import type { Option } from '@/types';

defineProps<{
    label: string;
    name: string;
    options: Option[] | any[];
    defaultValue?: string | number;
    placeholder?: string;
    optionLabel?: string;
    optionValue?: string;
    modelValue?: any; // for filters
}>();

const emit = defineEmits<{
    (e: 'update:modelValue', value: any): void;
}>();
</script>

<template>
    <div class="grid gap-2">
        <Label :for="name">
            {{ label }}
        </Label>

        <Select
            :name="name"
            :default-value="defaultValue"
            :model-value="modelValue"
            @update:model-value="emit('update:modelValue', $event)"
        >
            <SelectTrigger class="w-full">
                <SelectValue :placeholder="placeholder ?? `Select ${label}`" />
            </SelectTrigger>

            <SelectContent>
                <SelectGroup>
                    <SelectLabel>
                        {{ label }}
                    </SelectLabel>

                    <SelectItem
                        v-for="option in options"
                        :key="optionValue ? option[optionValue] : option"
                        :value="optionValue ? option[optionValue] : option"
                    >
                        {{ optionLabel ? option[optionLabel] : option }}
                    </SelectItem>
                </SelectGroup>
            </SelectContent>
        </Select>
    </div>
</template>
