<script setup lang="ts">
import { Badge } from '@/components/ui/badge';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import gamestation from './gamestation.png';
import pacheco from './pacheco.png';
import roboto from './roboto.png';
import runner from './runner.png';

interface HowItWorksProps {
    badgeTitle: string;
    title: string;
    description: string;
    image: string;
}

const HowItWorksList: HowItWorksProps[] = [
    {
        badgeTitle: 'Register',
        title: 'Create Your Account & Starting Balance',
        description:
            'Sign up, create your financial account, and set your initial balance to start tracking your money instantly.',
        image: roboto,
    },
    {
        badgeTitle: 'Track',
        title: 'Add and Organize Your Transactions',
        description:
            'Record your income and expenses with a simple workflow designed for fast and efficient financial tracking.',
        image: runner,
    },
    {
        badgeTitle: 'Automate',
        title: 'Set Up Recurring Transactions',
        description:
            'Automate daily, weekly, monthly, or yearly transactions so routine financial activity manages itself.',
        image: pacheco,
    },
    {
        badgeTitle: 'Improve',
        title: 'Build Better Financial Habits',
        description:
            'Monitor your balance, review your financial activity, and make smarter spending decisions over time.',
        image: gamestation,
    },
];
</script>

<template>
    <section
        id="features"
        class="container mx-auto w-[90%] py-24 sm:py-32 md:w-[70%] lg:w-[75%] lg:max-w-7xl"
    >
        <div class="mb-8 text-center">
            <h2 class="mb-2 text-center text-lg tracking-wider text-primary">
                How It Works
            </h2>

            <h2 class="text-center text-3xl font-bold md:text-4xl">
                Simple Workflow, Powerful Control
            </h2>
        </div>

        <div class="relative mx-auto lg:w-[80%]">
            <div
                v-for="(
                    { badgeTitle, title, description, image }, index
                ) in HowItWorksList"
                :key="title"
                :class="[
                    'mb-8 flex items-center',
                    { 'flex-row-reverse': index % 2 !== 0 },
                ]"
            >
                <Card class="h-full gap-4 border-0 bg-transparent shadow-none">
                    <CardHeader>
                        <div class="pb-4">
                            <Badge>{{ badgeTitle }}</Badge>
                        </div>

                        <CardTitle class="text-2xl">
                            {{ title }}
                        </CardTitle>
                    </CardHeader>

                    <CardContent class="w-[80%] text-muted-foreground">
                        {{ description }}
                    </CardContent>
                </Card>

                <img
                    :src="image"
                    :alt="`Image describing ${title} `"
                    class="z-1 mx-auto w-37.5 -scale-x-100 md:w-62.5 lg:w-75"
                />
                <div
                    :class="[
                        'absolute right-0 z-0 h-72 w-44 rounded-full bg-primary/15 blur-3xl lg:h-80 lg:w-64 dark:bg-primary/10',
                        {
                            'left-0': index % 2 !== 0,
                        },
                    ]"
                ></div>
            </div>
        </div>
    </section>
</template>
