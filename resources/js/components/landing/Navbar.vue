<script lang="ts" setup>
import { Link } from '@inertiajs/vue3';
import { Menu } from 'lucide-vue-next';
import { ref } from 'vue';
import { Button } from '@/components/ui/button';
import {
    NavigationMenu,
    NavigationMenuItem,
    NavigationMenuLink,
    NavigationMenuList,
} from '@/components/ui/navigation-menu';
import {
    Sheet,
    SheetContent,
    SheetFooter,
    SheetHeader,
    SheetTitle,
    SheetTrigger,
} from '@/components/ui/sheet';
import { home } from '@/routes';
import Controls from './Controls.vue';

interface RouteProps {
    href: string;
    label: string;
}

const routeList: RouteProps[] = [
    {
        href: '#benefits',
        label: 'Benefits',
    },
    {
        href: '#features',
        label: 'Features',
    },
    {
        href: '#how-it-works',
        label: 'How It Works',
    },
    {
        href: '#join-us',
        label: 'Join Us',
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
        <Link
            :to="home()"
            class="flex h-10! items-center text-xl font-extrabold!"
        >
            <img src="./logo.svg" class="w-10 px-0! lg:w-16" />
            <span class="hidden font-extrabold lg:inline">Pocket</span
            ><span class="hidden text-primary lg:inline">Pilot</span>
        </Link>
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
                                <Link
                                    :to="home()"
                                    class="flex h-10! items-center text-xl font-extrabold!"
                                >
                                    <img
                                        src="./logo.svg"
                                        class="w-10 px-0! lg:w-16"
                                    />
                                    <span class="font-extrabold">Pocket</span
                                    ><span class="text-primary">Pilot</span>
                                </Link>
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
                                <Link @click="isOpen = false" :href="href">
                                    {{ label }}
                                </Link>
                            </Button>
                        </div>
                    </div>

                    <SheetFooter
                        class="flex flex-row items-center justify-center"
                    >
                        <Controls />
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
                            <Link :href="href">
                                {{ label }}
                            </Link>
                        </Button>
                    </NavigationMenuLink>
                </NavigationMenuItem>
            </NavigationMenuList>
        </NavigationMenu>

        <div class="hidden lg:flex">
            <Controls />
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
