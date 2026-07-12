<script setup lang="ts">
import { Form } from '@inertiajs/vue3';
import { computed } from 'vue';
import FormDialog from '@/components/ReusableForm/FormDialog.vue';
import FormFooter from '@/components/ReusableForm/FormFooter.vue';
import type { FormDetails, InputType } from '@/types';

const props = defineProps<{
    element?: any;
    inputs: InputType[];
    details: FormDetails;
}>();

const formAction = computed(() => {
    if (props.element) {
        const route = props.details.update({
            [props.details.resourceKey]: props.element.id,
        });

        return {
            ...route,
            action: route.url,
        };
    }

    return props.details.store.form();
});
</script>

<template>
    <FormDialog
        :title="element ? details.title.update : details.title.store"
        :description="details.title.description"
    >
        <Form
            v-bind="formAction"
            :reset-on-success="inputs.map((input) => input.name)"
            v-slot="{ processing }"
            class="flex flex-col gap-6"
        >
            <div class="grid gap-6">
                <template v-for="input in inputs" :key="input.name">
                    <component
                        :is="input.component"
                        v-bind="input"
                        :options="
                            input.getOptions
                                ? input.getOptions()
                                : input.options
                        "
                        :default-value="
                            input.getValue
                                ? input.getValue(element)
                                : (element?.[input.name] ?? input.defaultValue)
                        "
                    />
                </template>
                <FormFooter :processing="processing" :entity="element" />
            </div>
        </Form>
    </FormDialog>
</template>
