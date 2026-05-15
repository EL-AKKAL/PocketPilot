<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Wallet, ArrowRight } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardHeader,
    CardTitle,
    CardFooter,
    CardContent,
} from '@/components/ui/card';
import { dashboard, login } from '@/routes';
</script>

<template>
    <section id="join-us" class="py-12">
        <hr />
        <div
            class="container mx-auto w-[90%] py-20 sm:py-20 md:w-[70%] lg:w-[75%] lg:max-w-7xl"
        >
            <Card
                class="flex flex-col items-center justify-center border-0 bg-background py-0 text-center shadow-none"
            >
                <CardHeader class="w-full">
                    <CardTitle class="w-full text-4xl font-bold md:text-5xl">
                        <Component class="m-auto mb-4 h-28 w-28" :is="Wallet" />
                        Ready to Take Control of Your
                        <span
                            class="bg-linear-to-r from-[#D247BF] to-primary bg-clip-text text-transparent"
                        >
                            Finances?
                        </span>
                    </CardTitle>
                </CardHeader>
                <CardContent class="text-xl text-muted-foreground lg:w-[80%]">
                    Track your spending, automate recurring transactions, and
                    stay in control of your financial life — all in one simple
                    and modern dashboard. 🚀
                </CardContent>

                <CardFooter class="flex w-full items-center justify-center">
                    <Button
                        as-child
                        class="group/arrow flex w-5/6 text-xl font-bold md:w-1/4"
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
                </CardFooter>
            </Card>
        </div>
        <hr />
    </section>
</template>
