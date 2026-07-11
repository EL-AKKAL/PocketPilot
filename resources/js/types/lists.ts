import type { Category } from './models';

export interface MostUsedCategories {
    income: {
        category: string;
        count: number;
        total_amount: number;
    } | null;
    expense: {
        category: string;
        count: number;
        total_amount: number;
    } | null;
}

export interface SuggestedCategories {
    income: string[];
    expense: string[];
}

export interface Categories {
    income: Category[];
    expense: Category[];
}

export interface UpcomingObligations {
    type: string;
    title: string;
    amount: number;
    date: string;
    human_date: string;
}
