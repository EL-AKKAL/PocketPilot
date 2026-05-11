<script setup lang="ts">
import { Form } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Spinner } from '@/components/ui/spinner';
import { store } from '@/routes/account';
</script>

<template>
    <div class="mx-auto max-w-md p-6">
        <h1 class="mb-4 text-2xl font-bold">Create Your Account</h1>

        <Form
            v-bind="store.form()"
            v-slot="{ processing }"
            class="flex flex-col gap-6"
        >
            <input
                name="name"
                type="text"
                placeholder="Account name"
                class="w-full rounded border p-2"
            />

            <input
                name="starting_balance"
                type="number"
                step="0.01"
                placeholder="Starting balance"
                class="w-full rounded border p-2"
            />

            <Button
                type="submit"
                class="mt-4 w-full"
                :tabindex="4"
                :disabled="processing"
                data-test="login-button"
            >
                <Spinner v-if="processing" />
                Create Account
            </Button>
        </Form>
    </div>
</template>
