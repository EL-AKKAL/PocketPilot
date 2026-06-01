import type { InertiaLinkProps } from '@inertiajs/vue3';
import { clsx } from 'clsx';
import type { ClassValue } from 'clsx';
import { twMerge } from 'tailwind-merge';
export * from './badgeStyles';

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs));
}

export function toUrl(href: NonNullable<InertiaLinkProps['href']>) {
    return typeof href === 'string' ? href : href?.url;
}

export function currency(amount: number | string | null | undefined) {
    const value = Number(amount ?? 0);

    if (Number.isNaN(value)) {
        return '0.00 MAD';
    }

    return value.toFixed(2) + ' MAD';
}
