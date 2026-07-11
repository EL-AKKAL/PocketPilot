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
