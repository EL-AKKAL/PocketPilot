<script setup lang="ts">
import {
    Paintbrush,
    MessageCircle,
    TabletSmartphone,
    BadgeCheck,
    Goal,
    PictureInPicture,
    MousePointerClick,
    Newspaper,
    CalendarRange,
} from 'lucide-vue-next';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';

interface FeaturesProps {
    icon: string;
    title: string;
    description: string;
}

const featureList: FeaturesProps[] = [
    {
        icon: 'tabletSmartphone',
        title: 'Responsive Dashboard',
        description:
            'Access your finances from desktop, tablet, or mobile with a fully responsive interface.',
    },
    {
        icon: 'badgeCheck',
        title: 'Reliable Transaction Tracking',
        description:
            'Keep your financial records organized with accurate balance and transaction management.',
    },
    {
        icon: 'calendarRange',
        title: 'Recurring Transaction Automation',
        description:
            'Automate repetitive income and expense entries with flexible recurring schedules.',
    },
    {
        icon: 'pictureInPicture',
        title: 'Clean Visual Experience',
        description:
            'Enjoy a distraction-free UI designed to make financial management intuitive and enjoyable.',
    },
    {
        icon: 'goal',
        title: 'Periodic Goals Tracking',
        description:
            'Set monthly or custom goals and track your progress over time to stay in control of your finances.',
    },
    {
        icon: 'newspaper',
        title: 'Clear Financial Overview',
        description:
            'Instantly understand your balance, spending habits, and recent activity from one place.',
    },
];

const iconMap: Record<
    string,
    | typeof TabletSmartphone
    | typeof BadgeCheck
    | typeof Goal
    | typeof PictureInPicture
    | typeof Paintbrush
    | typeof MousePointerClick
    | typeof MessageCircle
    | typeof Newspaper
    | typeof CalendarRange
> = {
    tabletSmartphone: TabletSmartphone,
    badgeCheck: BadgeCheck,
    goal: Goal,
    pictureInPicture: PictureInPicture,
    paintbrush: Paintbrush,
    mousePointerClick: MousePointerClick,
    messageCircle: MessageCircle,
    newspaper: Newspaper,
    calendarRange: CalendarRange,
};
</script>

<template>
    <section
        id="features"
        class="container mx-auto w-[90%] py-24 sm:py-32 md:w-[70%] lg:w-[75%] lg:max-w-7xl"
    >
        <h2 class="mb-2 text-center text-lg tracking-wider text-primary">
            Features
        </h2>

        <h2 class="mb-4 text-center text-3xl font-bold md:text-4xl">
            What Makes Us Different
        </h2>

        <h3
            class="mx-auto mb-8 text-center text-xl text-muted-foreground md:w-1/2"
        >
            PocketPilot combines modern design with practical financial tools to
            help you manage your money faster, easier, and with complete
            clarity.
        </h3>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <div
                v-for="{ icon, title, description } in featureList"
                :key="title"
            >
                <Card class="h-full gap-4 border-0 bg-background shadow-none">
                    <CardHeader
                        class="flex flex-col items-center justify-center"
                    >
                        <div
                            class="mb-4 rounded-full bg-primary/20 p-2 ring-8 ring-primary/10"
                        >
                            <component
                                :is="iconMap[icon]"
                                class="size-6 text-primary"
                            />
                        </div>

                        <CardTitle>
                            {{ title }}
                        </CardTitle>
                    </CardHeader>

                    <CardContent class="text-center text-muted-foreground">
                        {{ description }}
                    </CardContent>
                </Card>
            </div>
        </div>
    </section>
</template>

<style lang="less" scoped></style>
