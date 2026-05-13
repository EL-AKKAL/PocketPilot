<script setup lang="ts">
import { Moon, Sun } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import { useAppearance } from '@/composables/useAppearance';

const { isDark, updateAppearance } = useAppearance();
</script>

<template>
    <Button
        @click="updateAppearance(isDark ? 'light' : 'dark')"
        size="sm"
        variant="ghost"
        class="justify-start"
    >
        <div v-if="!isDark" class="flex gap-2">
            <Moon class="size-5" />
            <span class="block lg:hidden"> Dark </span>
        </div>

        <div v-else class="flex gap-2">
            <Sun class="size-5" />
            <span class="block lg:hidden">Light</span>
        </div>

        <span class="sr-only">Toggle theme</span>
    </Button>
</template>
