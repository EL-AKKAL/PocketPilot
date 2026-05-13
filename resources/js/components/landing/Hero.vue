<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

import { ArrowRight } from 'lucide-vue-next';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { dashboard, login } from '@/routes';
</script>

<template>
    <section class="container mx-auto px-4">
        <div
            class="mx-auto! grid place-items-center gap-8 py-20 md:py-32 lg:max-w-7xl"
        >
            <div class="space-y-8 text-center">
                <Badge variant="outline" class="py-2 text-sm">
                    <span class="mr-2 text-primary">
                        <Badge>New</Badge>
                    </span>
                    <span> Smart recurring transactions</span>
                </Badge>

                <div
                    class="mx-auto max-w-3xl text-center text-5xl font-bold md:text-6xl"
                >
                    <h1>
                        Take Control of your
                        <span
                            class="bg-linear-to-r from-[#D247BF] to-primary bg-clip-text text-transparent"
                        >
                            Personal Finances
                        </span>
                        Without the Chaos
                    </h1>
                </div>

                <p
                    class="mx-auto max-w-screen-sm text-xl text-muted-foreground"
                >
                    Track expenses, manage recurring transactions, and
                    understand your financial habits with a clean and powerful
                    dashboard built for everyday use.
                </p>

                <div class="space-y-4 md:space-y-0 md:space-x-4">
                    <Button
                        as-child
                        class="group/arrow w-5/6 font-bold md:w-1/4"
                    >
                        <Link v-if="$page.props.auth.user" :href="dashboard()">
                            Launch Dashboard
                            <ArrowRight
                                class="ml-2 size-5 transition-transform group-hover/arrow:translate-x-1"
                            />
                        </Link>
                        <Link v-else :href="login()">
                            Start Tracking
                            <ArrowRight
                                class="ml-2 size-5 transition-transform group-hover/arrow:translate-x-1"
                            />
                        </Link>
                    </Button>
                    <Button
                        as-child
                        variant="secondary"
                        class="w-5/6 font-bold md:w-1/4"
                    >
                        <a
                            href="https://github.com/EL-AKKAL/PocketPilot"
                            target="_blank"
                        >
                            View on GitHub
                        </a>
                    </Button>
                </div>
            </div>
        </div>
    </section>
</template>
