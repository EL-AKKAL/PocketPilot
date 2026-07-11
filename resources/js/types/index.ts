export * from './auth';
export * from './navigation';
export * from './ui';
export * from './data-table';

export interface Transaction {
    id: number;
    amount: number;
    category_id: number;
    description: string;
    created_at: string;
    category?: Category;
}

export interface PeriodicTransaction {
    id: number;
    amount: number;
    category_id: number;
    description: string;
    start_date: string;
    end_date: string;
    frequency: string;
    is_active: boolean;
    next_apply_date: string;
    created_at: string;
    category?: Category;
}

export interface Goal {
    id: number;
    value: number;
    account_id: string;
    start_at: string;
    ends_at: string;
    period: string;
    type: string;
    status: string;
    created_at: string;
    updated_at: string;
}

export interface GoalStatistic {
    value: number;
    period: string;
    progress: number;
    percentage: number;
    status: string;
    ends_at: string;
    type: string;
    id: number;
}
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

export interface Category {
    id: number;
    value: string;
    type: string;
    created_at: string;
}

export interface Categories {
    income: Category[];
    expense: Category[];
}

export interface Debt {
    id: number;
    amount: number;
    description: string;
    due_date: string;
    paid_at: string;
    created_at: string;
}

export interface FilterDefinition {
    type: 'select';
    field: string;
    label: string;
    options: Option[];
}

export interface Option {
    value: string;
    label: string;
}

export interface MonthlyNetWorthTrend {
    month: string;
    income: number;
    expense: number;
    net: number;
}

export interface UpcomingObligations {
    type: string;
    title: string;
    amount: number;
    date: string;
    human_date: string;
}

export interface InputType {
    name: string;
    type: string;
    label: string;
    component?: any;
    defaultValue?: any;
    placeholder?: string;
    min?: number;
    getValue?: (element: any) => any;
}

export interface FormDetails {
    title: {
        store: string;
        update: string;
        description: string;
    };
    store: StoreMethod;
    update: UpdateMethod;
    resourceKey: string;
}

export type StoreMethod = {
    form: () => any;
};

export type UpdateMethod = (...args: any[]) => any;
