import { currency } from '@/lib/utils';

export function useChartOptions() {
    const isDark = document.documentElement.classList.contains('dark');
    const textColor = isDark ? '#e5e7eb' : '#374151';
    const gridColor = isDark ? '#374151' : '#e5e7eb';

    const baseChart = {
        height: 300,
        toolbar: { show: false },
        zoom: { enabled: false },
    };

    const tooltip = {
        theme: isDark ? 'dark' : 'light',
        y: {
            formatter: (val: number) => currency(val),
        },
    };

    const axis = {
        labels: {
            style: {
                colors: textColor,
                fontSize: '12px',
            },
        },
    };

    const yaxis = {
        labels: {
            style: {
                colors: textColor,
            },
            formatter: (val: number) => val.toFixed(0),
        },
    };

    const grid = {
        borderColor: gridColor,
    };

    return {
        baseChart,
        tooltip,
        axis,
        yaxis,
        grid,
        textColor,
    };
}
