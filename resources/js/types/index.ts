export * from './auth';
export * from './navigation';
export * from './ui';
export * from './data-table';

export interface Transaction {
    id: number;
    amount: number;
    category: string;
    description: string;
    account_id: string;
    created_at: string;
    updated_at: string;
}

export interface PeriodicTransaction {
    id: number;
    amount: number;
    category: string;
    description: string;
    account_id: string;
    start_date: string;
    end_date: string;
    frequency: string;
    is_active: boolean;
    next_apply_date: string;
    created_at: string;
    updated_at: string;
}

export interface Category {
    expense: string[];
    income: string[];
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
    starts_at: string;
    account_id: number;
}
