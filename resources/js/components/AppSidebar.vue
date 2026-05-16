<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import {
    BookOpen,
    CalendarSync,
    FolderGit2,
    LayoutGrid,
    Receipt,
} from 'lucide-vue-next';
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { dashboard } from '@/routes';
import { index as periodicTransactions } from '@/routes/periodic_transactions';
import { index as transactions } from '@/routes/transactions';
import type { NavItem } from '@/types';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: dashboard(),
        icon: LayoutGrid,
    },
    {
        title: 'Transactions',
        href: transactions(),
        icon: Receipt,
    },
    {
        title: 'Periodic Transactions',
        href: periodicTransactions(),
        icon: CalendarSync,
    },
];

const footerNavItems: NavItem[] = [
    {
        title: 'Repository',
        href: 'https://github.com/EL-AKKAL/PocketPilot',
        icon: FolderGit2,
    },
    {
        title: 'Portfolio',
        href: 'https://elakkalayoub.cloud',
        icon: BookOpen,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="dashboard()" class="text-xl!">
                            <img
                                src="../components/landing/logo.svg"
                                class="w-10 px-0! lg:w-16"
                            />
                            <span class="hidden font-extrabold lg:inline"
                                >Pocket</span
                            ><span class="hidden text-primary lg:inline"
                                >Pilot</span
                            >
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
