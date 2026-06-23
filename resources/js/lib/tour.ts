import { driver } from 'driver.js';
import 'driver.js/dist/driver.css';

export function startTour() {
    const tour = driver({
        showProgress: true,
        animate: true,
        allowClose: true,
        overlayOpacity: 0.8,

        steps: [
            {
                element: '#dashboard-link',
                popover: {
                    title: 'Dashboard',
                    description:
                        'Your financial overview. Monitor balances, spending trends, goal progress, upcoming obligations, and recent activity from a single place.',
                },
            },

            {
                element: '#transactions-link',
                popover: {
                    title: 'Transactions',
                    description:
                        'Record income and expenses. Every movement of money should be tracked here so your reports remain accurate.',
                },
            },

            {
                element: '#categories-link',
                popover: {
                    title: 'Categories',
                    description:
                        'Organize transactions into groups such as Salary, Bills, Food, Transport, or Entertainment. Categories organize your transactions and drive most reports and insights. Every category is either Income or Expense, so make sure transactions are categorized correctly.',
                },
            },

            {
                element: '#goals-link',
                popover: {
                    title: 'Goals',
                    description:
                        'Goals help track spending or savings targets. Only goals currently in progress can be edited. When a goal period ends, PocketPilot automatically creates the next goal in the sequence during the daily midnight check.',
                },
            },

            {
                element: '#periodic-link',
                popover: {
                    title: 'Periodic Transactions',
                    description:
                        'Use periodic transactions for recurring income or expenses such as salary, rent, subscriptions, or bills. PocketPilot checks them every midnight and automatically creates any transaction that becomes due.',
                },
            },

            {
                element: '#debts-link',
                popover: {
                    title: 'Debts',
                    description:
                        'Track money you owe and keep an eye on due dates. Marking a debt as paid automatically creates the corresponding expense transaction and updates your financial records.',
                },
            },

            {
                element: '#settings-link',
                popover: {
                    title: 'Settings',
                    description:
                        'Customize your experience, manage your account, and configure application preferences.',
                },
            },
            {
                popover: {
                    title: "You're ready",
                    description:
                        'Start by creating a few categories and recording your first transactions. You can reopen this tour at any time using the Help button in the sidebar.',
                },
            },
        ],
    });

    tour.drive();
}
