<script setup lang="ts">
import Navbar from '@/components/landing/Navbar.vue';
import Hero from '@/components/landing/Hero.vue';
withDefaults(
    defineProps<{
        canRegister: boolean;
    }>(),
    {
        canRegister: true,
    },
);
</script>

<template>
    <Navbar />
    <Hero />
</template>
