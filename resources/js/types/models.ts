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

export interface Category {
    id: number;
    value: string;
    type: string;
    created_at: string;
}

export interface Debt {
    id: number;
    amount: number;
    description: string;
    due_date: string;
    paid_at: string;
    created_at: string;
}
