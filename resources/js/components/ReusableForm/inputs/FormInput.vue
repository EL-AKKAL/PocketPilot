<script setup lang="ts">
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

defineProps<{
    label: string;
    name: string;
    type?: string;
    placeholder?: string;
    defaultValue?: string | number;
    required?: boolean;
    min?: string | number;
}>();
</script>

<template>
    <div class="grid gap-2">
        <Label :for="name">
            {{ label }}
        </Label>

        <Input
            :name
            :required
            :placeholder
            :id="name"
            :min="min"
            :type="type ?? 'text'"
            :default-value="defaultValue"
        />
    </div>
</template>
