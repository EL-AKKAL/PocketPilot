export const categoryStyles: string =
    'inline-flex items-center rounded-md px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-700 dark:bg-yellow-500/10 dark:text-yellow-300';

export const statusStyles: Record<string, string> = {
    failed: 'bg-red-100 text-red-700 dark:bg-red-500/10 dark:text-red-300',
    achieved:
        'bg-green-100 text-green-700 dark:bg-green-500/10 dark:text-green-300',
    in_progress:
        'bg-yellow-100 text-yellow-700 dark:bg-yellow-500/10 dark:text-yellow-300',
};
