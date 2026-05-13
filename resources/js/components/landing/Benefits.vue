<script setup lang="ts">
import {
    Sparkle,
    Tag,
    Paintbrush,
    Blocks,
    LineChart,
    Wallet,
} from 'lucide-vue-next';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';

interface BenefitsProps {
    icon: string;
    title: string;
    description: string;
}

const benefitList: BenefitsProps[] = [
    {
        icon: 'wallet',
        title: 'Smart Expense Tracking',
        description:
            'Keep all your financial activity organized in one secure and easy-to-use dashboard.',
    },
    {
        icon: 'lineChart',
        title: 'Financial Insights',
        description:
            'Get a better understanding of your habits through clear summaries and balance tracking.',
    },
    {
        icon: 'blocks',
        title: 'Automated Payments',
        description:
            'Handle recurring transactions automatically so you never lose track of routine expenses.',
    },
    {
        icon: 'sparkle',
        title: 'Built for Simplicity',
        description:
            'Enjoy a modern interface designed to make personal finance management effortless.',
    },
];

const iconMap: Record<
    string,
    | typeof Sparkle
    | typeof Tag
    | typeof Paintbrush
    | typeof Blocks
    | typeof LineChart
    | typeof Wallet
> = {
    sparkle: Sparkle,
    tag: Tag,
    paintbrush: Paintbrush,
    blocks: Blocks,
    lineChart: LineChart,
    wallet: Wallet,
};
</script>

<template>
    <section
        id="benefits"
        class="container mx-auto w-[90%] py-24 sm:py-32 md:w-[70%] lg:w-[75%] lg:max-w-7xl"
    >
        <div class="grid place-items-center lg:grid-cols-2 lg:gap-24">
            <div>
                <h2 class="mb-2 text-lg tracking-wider text-primary">
                    Benefits
                </h2>

                <h2 class="mb-4 text-3xl font-bold md:text-4xl">
                    Everything You Need to Manage Your Money
                </h2>
                <p class="mb-8 text-xl text-muted-foreground">
                    Designed for simplicity and clarity, PocketPilot helps you
                    stay in control of your finances without complicated
                    spreadsheets or outdated budgeting apps.
                </p>
            </div>

            <div class="grid w-full gap-4 lg:grid-cols-2">
                <Card
                    v-for="({ icon, title, description }, index) in benefitList"
                    :key="title"
                    class="group/number gap-3! bg-muted/50 transition-all delay-75 hover:bg-background dark:bg-card dark:hover:bg-background"
                >
                    <CardHeader>
                        <div class="flex justify-between">
                            <component
                                class="mb-2 size-8 text-primary"
                                :is="iconMap[icon]"
                            />

                            <span
                                class="text-5xl font-medium text-muted-foreground/15 transition-all delay-75 group-hover/number:text-muted-foreground/30"
                                >0{{ index + 1 }}</span
                            >
                        </div>

                        <CardTitle>{{ title }}</CardTitle>
                    </CardHeader>

                    <CardContent class="text-muted-foreground">
                        {{ description }}
                    </CardContent>
                </Card>
            </div>
        </div>
    </section>
</template>
