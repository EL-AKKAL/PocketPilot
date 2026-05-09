<script setup>
import { Form } from '@inertiajs/vue3';
import { store } from '@/routes/account';
import { Spinner } from '@/components/ui/spinner';
import { Button } from '@/components/ui/button';
</script>

<template>
  <div class="p-6 max-w-md mx-auto">
    <h1 class="text-2xl font-bold mb-4">Create Your Account</h1>

      <Form
        v-bind="store.form()"
        v-slot="{ errors, processing }"
        class="flex flex-col gap-6"
    >
 <input
 name="name"
        type="text"
        placeholder="Account name"
        class="w-full border p-2 rounded"
      />

      <input
        name="starting_balance"
        type="number"
        step="0.01"
        placeholder="Starting balance"
        class="w-full border p-2 rounded"
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
