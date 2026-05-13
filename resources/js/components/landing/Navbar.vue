<script lang="ts" setup>
import { dashboard, login } from '@/routes';
import { Link } from '@inertiajs/vue3';
import { useColorMode } from '@vueuse/core';
import { Menu } from 'lucide-vue-next';
import { ref } from 'vue';

const mode = useColorMode();
mode.value = 'dark';

import { Button } from '@/components/ui/button';
import {
    NavigationMenu,
    NavigationMenuItem,
    NavigationMenuLink,
    NavigationMenuList,
} from '@/components/ui/navigation-menu';
import { Separator } from '@/components/ui/separator';
import {
    Sheet,
    SheetContent,
    SheetFooter,
    SheetHeader,
    SheetTitle,
    SheetTrigger,
} from '@/components/ui/sheet';

import GithubIcon from './GithubIcon.vue';
import ToggleTheme from './ToggleTheme.vue';

interface RouteProps {
    href: string;
    label: string;
}

const routeList: RouteProps[] = [
    {
        href: '#testimonials',
        label: 'Testimonials',
    },
    {
        href: '#team',
        label: 'Team',
    },
    {
        href: '#contact',
        label: 'Contact',
    },
    {
        href: '#faq',
        label: 'FAQ',
    },
];

const isOpen = ref<boolean>(false);
</script>

<template>
    <header
        class="shadow-light dark:shdow-dark sticky top-5 z-40 mx-auto flex w-[90%] items-center justify-between rounded-2xl border bg-card p-2 shadow-md md:w-[70%] lg:w-[75%] lg:max-w-7xl"
    >
        <a href="/" class="flex h-10! items-center text-xl font-extrabold!">
            <img src="./logo.svg" class="w-10 px-0! lg:w-16" />
            <span class="hidden font-extrabold lg:inline">Pocket</span
            ><span class="hidden text-primary lg:inline">Pilot</span>
        </a>
        <!-- Mobile -->
        <div class="flex items-center lg:hidden">
            <Sheet v-model:open="isOpen">
                <SheetTrigger as-child>
                    <Menu @click="isOpen = true" class="cursor-pointer" />
                </SheetTrigger>

                <SheetContent
                    side="left"
                    class="flex flex-col justify-between rounded-tr-2xl rounded-br-2xl bg-card"
                >
                    <div>
                        <SheetHeader class="mb-2">
                            <SheetTitle class="flex items-center">
                                <a
                                    href="/"
                                    class="flex h-10! items-center text-xl font-extrabold!"
                                >
                                    <img
                                        src="./logo.svg"
                                        class="w-10 px-0! lg:w-16"
                                    />
                                    <span class="font-extrabold">Pocket</span
                                    ><span class="text-primary">Pilot</span>
                                </a>
                            </SheetTitle>
                        </SheetHeader>

                        <div class="flex flex-col gap-2">
                            <Button
                                v-for="{ href, label } in routeList"
                                :key="label"
                                as-child
                                variant="ghost"
                                class="justify-start text-base"
                            >
                                <a @click="isOpen = false" :href="href">
                                    {{ label }}
                                </a>
                            </Button>
                        </div>
                    </div>

                    <SheetFooter
                        class="flex-col items-start justify-start sm:flex-col"
                    >
                        <Link
                            v-if="$page.props.auth.user"
                            :href="dashboard()"
                            class="px-5 py-1.5 text-sm"
                        >
                            Dashboard
                        </Link>
                        <Link
                            v-else
                            :href="login()"
                            class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
                        >
                            Sign in
                        </Link>
                        <Separator class="mb-2" />

                        <ToggleTheme />
                    </SheetFooter>
                </SheetContent>
            </Sheet>
        </div>

        <!-- Desktop -->
        <NavigationMenu class="hidden w-full lg:block">
            <NavigationMenuList>
                <NavigationMenuItem class="flex">
                    <NavigationMenuLink asChild>
                        <Button
                            v-for="{ href, label } in routeList"
                            :key="label"
                            as-child
                            variant="ghost"
                            class="justify-start text-base"
                        >
                            <a :href="href">
                                {{ label }}
                            </a>
                        </Button>
                    </NavigationMenuLink>
                </NavigationMenuItem>
            </NavigationMenuList>
        </NavigationMenu>

        <div class="hidden lg:flex">
            <Link
                v-if="$page.props.auth.user"
                :href="dashboard()"
                class="flex items-center rounded-sm border border-primary px-5 text-sm text-primary"
            >
                Dashboard
            </Link>
            <Link
                v-else
                :href="login()"
                class="flex items-center rounded-sm border border-primary px-5 text-sm text-primary"
            >
                Sign in
            </Link>
            <ToggleTheme />

            <Button
                as-child
                size="sm"
                variant="ghost"
                aria-label="View on GitHub"
            >
                <a
                    aria-label="View on GitHub"
                    href="https://github.com/leoMirandaa/shadcn-vue-landing-page.git"
                    target="_blank"
                >
                    <GithubIcon class="size-5" />
                </a>
            </Button>
        </div>
    </header>
</template>

<style scoped>
.shadow-light {
    box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.085);
}

.shadow-dark {
    box-shadow: inset 0 0 5px rgba(255, 255, 255, 0.141);
}
</style>
