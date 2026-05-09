export * from './auth';
export * from './navigation';
export * from './ui';
export * from './data-table';

export interface Transaction {
    id: number;
    amount: number;
    description: string;
    account_id: string;
    created_at: string;
    updated_at: string;
}

export interface PeriodicTransaction {
    id: string;
    amount: number;
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
