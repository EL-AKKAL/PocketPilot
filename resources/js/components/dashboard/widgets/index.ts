import type { VariantProps } from 'class-variance-authority';
import { cva } from 'class-variance-authority';

export const WidgetVariant = cva('', {
    variants: {
        variant: {
            default: 'text-primary',
            success: 'text-green-500',
            danger: 'text-red-500',
        },
        size: {
            default: 'text-lg font-bold lg:text-2xl',
            sm: 'text-md font-bold lg:text-xl',
        },
    },
    defaultVariants: {
        variant: 'default',
        size: 'default',
    },
});
export type WidgetVariant = VariantProps<typeof WidgetVariant>;
