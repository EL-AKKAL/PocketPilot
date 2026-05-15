<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { dashboard, login } from '@/routes';

import GithubIcon from './GithubIcon.vue';
import ToggleTheme from './ToggleTheme.vue';
</script>
<template>
    <Link
        v-if="$page.props.auth.user"
        :href="dashboard()"
        class="text-md flex items-center rounded-sm border border-primary px-5 text-primary"
    >
        Dashboard
    </Link>
    <Link
        v-else
        :href="login()"
        class="text-md flex items-center rounded-sm border border-primary px-5 text-primary"
    >
        Sign in
    </Link>
    <ToggleTheme />

    <Button as-child size="sm" variant="ghost" aria-label="View on GitHub">
        <a
            aria-label="View on GitHub"
            href="https://github.com/leoMirandaa/shadcn-vue-landing-page.git"
            target="_blank"
        >
            <GithubIcon class="size-5" />
        </a>
    </Button>
</template>
