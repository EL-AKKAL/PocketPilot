<script setup lang="ts">

import { getLocalTimeZone, parseDate, today } from '@internationalized/date';

import type { DateValue } from '@internationalized/date';
import { ref } from 'vue';
import type { Ref } from 'vue';
import { Calendar } from '@/components/ui/calendar';
import { Label } from '@/components/ui/label';

const props = defineProps<{
    name: string;
    label: string;
    defaultValue?: string;
}>();

const value = ref(
    props.defaultValue
        ? parseDate(props.defaultValue)
        : today(getLocalTimeZone()),
) as Ref<DateValue>;
</script>

<template>
    <div class="grid gap-2">
        <Label :for="name">{{ label }}</Label>

        <Calendar v-model="value" class="w-full rounded-md border shadow-sm" />

        <input
            type="hidden"
            :name="name"
            :value="
                value?.toDate(getLocalTimeZone()).toISOString().slice(0, 10)
            "
        />
    </div>
</template>
