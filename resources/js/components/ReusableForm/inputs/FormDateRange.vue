<script setup lang="ts">
import { getLocalTimeZone, parseDate, today } from '@internationalized/date';
import type { DateRange } from 'reka-ui';
import { ref } from 'vue';
import type { Ref } from 'vue';
import { Label } from '@/components/ui/label';
import { RangeCalendar } from '@/components/ui/range-calendar';

const props = defineProps<{
    label: string;
    startName?: string;
    endName?: string;
    startDefault?: string | null;
    endDefault?: string | null;
}>();

const dateRange = ref({
    start: props.startDefault
        ? parseDate(props.startDefault)
        : today(getLocalTimeZone()),

    end: props.endDefault ? parseDate(props.endDefault) : null,
}) as Ref<DateRange>;
</script>

<template>
    <div class="grid gap-2">
        <div class="flex items-center justify-between">
            <Label>{{ label }}</Label>
        </div>

        <RangeCalendar
            v-model="dateRange"
            class="w-full rounded-md border shadow-sm"
            :number-of-months="2"
            disable-days-outside-current-view
        />

        <input
            type="hidden"
            :name="startName ?? 'start_date'"
            :value="
                dateRange.start
                    ?.toDate(getLocalTimeZone())
                    .toISOString()
                    .slice(0, 10)
            "
        />

        <input
            type="hidden"
            :name="endName ?? 'end_date'"
            :value="
                dateRange.end
                    ?.toDate(getLocalTimeZone())
                    .toISOString()
                    .slice(0, 10)
            "
        />
    </div>
</template>
