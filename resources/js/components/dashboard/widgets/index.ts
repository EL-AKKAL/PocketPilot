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
            default: 'text-2xl font-bold',
            sm: 'text-xl font-bold',
        },
    },
    defaultVariants: {
        variant: 'default',
        size: 'default',
    },
});
export type WidgetVariant = VariantProps<typeof WidgetVariant>;
