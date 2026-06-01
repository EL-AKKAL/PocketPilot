<script setup lang="ts">
import {
    Accordion,
    AccordionContent,
    AccordionItem,
    AccordionTrigger,
} from '@/components/ui/accordion';

interface FAQProps {
    question: string;
    answer: string;
    value: string;
}

const FAQList: FAQProps[] = [
    {
        question: 'What is PocketPilot?',
        answer: 'PocketPilot is a personal finance management platform that helps you track transactions, monitor your balance, and automate recurring financial activity in one clean dashboard.',
        value: 'item-1',
    },
    {
        question: 'Can I track recurring transactions?',
        answer: 'Yes. PocketPilot supports recurring transactions with daily, weekly, monthly, and yearly frequencies so you can automate routine income and expenses.',
        value: 'item-2',
    },
    {
        question: 'How are goals tracked over time?',
        answer: 'Once a goal is created, all upcoming transactions are included in its progress automatically. You can track completed and past goals with full history on the goals page.',
        value: 'item-3',
    },
    {
        question: 'How is my balance calculated?',
        answer: 'Your balance is calculated using your starting account balance combined with all recorded transactions, giving you a real-time overview of your finances.',
        value: 'item-4',
    },
    {
        question: 'Can I use PocketPilot on mobile devices?',
        answer: 'Yes. The interface is fully responsive and works smoothly across desktops, tablets, and mobile devices.',
        value: 'item-5',
    },
    {
        question: 'Is PocketPilot free to use?',
        answer: 'Yes. PocketPilot is currently available as a free personal finance management solution.',
        value: 'item-6',
    },
];
</script>

<template>
    <section
        id="faq"
        class="container mx-auto w-[90%] py-24 sm:py-32 md:w-175 lg:w-[75%] lg:max-w-7xl"
    >
        <div class="mb-8 text-center">
            <h2 class="mb-2 text-center text-lg tracking-wider text-primary">
                FAQS
            </h2>

            <h2 class="text-center text-3xl font-bold md:text-4xl">
                Common Questions
            </h2>
        </div>

        <Accordion
            type="single"
            collapsible
            class="AccordionRoot mx-auto max-w-2xl"
        >
            <AccordionItem
                v-for="{ question, answer, value } in FAQList"
                :key="value"
                :value="value"
                class="my-2 rounded-md border border-foreground bg-accent/10 px-2"
            >
                <AccordionTrigger class="text-left">
                    {{ question }}
                </AccordionTrigger>

                <AccordionContent>{{ answer }}</AccordionContent>
            </AccordionItem>
        </Accordion>

        <h3 class="mx-auto mt-4! max-w-2xl font-medium">
            Still have questions?
            <a
                href="mailto:akkalayoub3@gmail.com"
                target="_blank"
                class="text-muted-foreground underline"
                >Contact us</a
            >
        </h3>
    </section>
</template>
