import type { InertiaLinkProps } from '@inertiajs/vue3';
import { clsx } from 'clsx';
import type { ClassValue } from 'clsx';
import { twMerge } from 'tailwind-merge';

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs));
}

export function toUrl(href: NonNullable<InertiaLinkProps['href']>) {
    return typeof href === 'string' ? href : href?.url;
}

export function currency(amount: number) {
    return amount.toFixed(2) + 'MAD';
}

export const categoryStyles: Record<string, string> = {
    // expense
    Emergencies:
        'inline-flex items-center rounded-md px-2 py-1 text-xs font-medium bg-red-100 text-red-700 dark:bg-red-500/10 dark:text-red-300',
    Bills: 'inline-flex items-center rounded-md px-2 py-1 text-xs font-medium bg-amber-100 text-amber-700 dark:bg-amber-500/10 dark:text-amber-300',
    Food: 'inline-flex items-center rounded-md px-2 py-1 text-xs font-medium bg-lime-100 text-lime-700 dark:bg-lime-500/10 dark:text-lime-300',
    Needs: 'inline-flex items-center rounded-md px-2 py-1 text-xs font-medium bg-pink-200 text-pink-700 dark:bg-pink-500/10 dark:text-pink-300',
    Transport:
        'inline-flex items-center rounded-md px-2 py-1 text-xs font-medium bg-cyan-100 text-cyan-700 dark:bg-cyan-500/10 dark:text-cyan-300',
    Fixes: 'inline-flex items-center rounded-md px-2 py-1 text-xs font-medium bg-blue-100 text-blue-700 dark:bg-blue-500/10 dark:text-blue-300',
    Wants: 'inline-flex items-center rounded-md px-2 py-1 text-xs font-medium bg-violet-100 text-violet-700 dark:bg-violet-500/10 dark:text-violet-300',

    // income
    Salary: 'inline-flex items-center rounded-md px-2 py-1 text-xs font-medium bg-fuchsia-100 text-fuchsia-700 dark:bg-fuchsia-500/10 dark:text-fuchsia-300',
    Freelance:
        'inline-flex items-center rounded-md px-2 py-1 text-xs font-medium bg-green-200 text-green-700 dark:bg-green-500/10 dark:text-green-300',
    Business:
        'inline-flex items-center rounded-md px-2 py-1 text-xs font-medium bg-gray-100 text-gray-700 dark:bg-gray-500/10 dark:text-gray-300',
    Investments:
        'inline-flex items-center rounded-md px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-700 dark:bg-yellow-500/10 dark:text-yellow-300',
    'Other Income':
        'inline-flex items-center rounded-md px-2 py-1 text-xs font-medium bg-mist-300 text-mist-700 dark:bg-mist-500/10 dark:text-mist-300',
};

export const statusStyles: Record<string, string> = {
    failed: 'bg-red-100 text-red-700 dark:bg-red-500/10 dark:text-red-300',
    achieved:
        'bg-green-100 text-green-700 dark:bg-green-500/10 dark:text-green-300',
    in_progress:
        'bg-yellow-100 text-yellow-700 dark:bg-yellow-500/10 dark:text-yellow-300',
};
