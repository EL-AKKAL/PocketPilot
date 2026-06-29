# PocketPilot V3 — Requirements

## Overview

PocketPilot V3 focuses on customization, better data management, improved financial insights, and overall usability.

This release introduces custom categories, debt management, search and filtering, a redesigned backup system, dashboard improvements, and numerous UI and codebase refinements.
- 
## 📊  Features

### Custom Categories (MUST)

 - Users have complete control over their transaction categories.

### Global Search

 - Search has been added across multiple modules.
 
 - Supported modules:
    Transactions
    Recurring Transactions
    Goals
    Categories
    Debts

### Simple Filters

 - Quick filtering has been introduced.

 - Available filters include:
    Transaction type
    Goal status
    Recurring frequency
    Debt status

### Debt Management

 - A completely new module for tracking money owed.

### Starter Categories

 - New users can now choose from predefined starter categories during onboarding instead of creating everything manually.

### Dashboard Upgrade

 - Two new dashboard widgets have been added.

 1. Monthly Net Worth Trend

    - Displays monthly: Income , Expenses , Net result

    - making long-term financial trends easier to understand.

 2. Upcoming Obligations

    - Shows the next upcoming financial commitments by combining: Unpaid debts , Upcoming recurring transactions

## ✨ Improvements

- Refactored reusable forms
- Better validation behavior
- Improved dropdown interactions
- Category search integration
- User Experience
- Help modal
- Better empty states
- Improved mobile experience
- Code Quality

Large portions of the codebase were refactored to improve maintainability.

- Highlights include:

    Cleaner controllers
    Reusable form components
    Reusable import/restore helpers
    Reduced code duplication
    Better separation of concerns
---

## Bug Fix

- fixing goals process
- validation errors issue
