export * from './auth';
export * from './navigation';
export * from './ui';
export * from './data-table';
export * from './models';
export * from './lists';

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

export interface MonthlyNetWorthTrend {
    month: string;
    income: number;
    expense: number;
    net: number;
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
    options?: string[];
    getOptions?: () => string[];
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
