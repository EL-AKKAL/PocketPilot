# Overview 
This document lists a minimal, human-readable set of system requirements for a 24‑hour MVP finance management web app built with laravel-vuejs. The focus is intentionally small: simple register/login, persistent accounts, one‑time and recurring transactions, a basic dashboard, and a few practical non‑functional targets.

## Plan Details

1. **Authentication (MUST)**
   - Users can register/login with email and password.

2. **User data isolation (MUST)**
   - Each user only sees their own accounts and transactions.

3. **Accounts (MUST)**
   - A user can create one account with a specific email and starting balance.

4. **One‑time transactions (MUST)**
   - Users can add, view, edit, and delete individual transactions.

5. **Recurring transactions (MUST — simple)**
   - Users can create a recurring rule with frequency options: daily, weekly, or monthly; start date and optional end date.
   - Recurring instances are generated on demand for display.
   - Users can edit or cancel the recurring rule; edits apply to future occurrences.

6. **Balances and dashboard (MUST)**
   - Dashboard shows per‑account balance (starting balance + transactions), consolidated total, and a short list of recent transactions.
   - Show a simple income vs expense summary for the current month.

7. **Performance & demo readiness (SHOULD)**
    - Pages should load quickly for normal single‑user use; aim for visible content within a few seconds on a typical connection.
    - The app must be runnable locally and deployable to a simple host within the 24‑hour window.

8. **Optional but recommended (MAY)**
    - Use of single default currency (e.g., USD) to avoid currency conversion complexity.
    - Basic export of transactions (CSV) may be added only if time remains.

### Acceptance criteria (top priorities)
- A user can register, log in, and only see their own data.
- A user can add/edit/delete a one‑time transaction, and see balances update.
- A user can create a recurring rule and view the upcoming instances for a requested date range.
- The dashboard shows per‑account balance, total balance, and a month income/expense summary.
- The app can be started locally and demonstrated within the 24‑hour timebox.

# User Journey map
<img width="1401" height="503" alt="image" src="https://github.com/user-attachments/assets/a2cc4e17-4c47-44d8-a9d9-9721f38d4f72" />

# Data Models
<img width="710" height="602" alt="image" src="https://github.com/user-attachments/assets/61aeab40-7967-471a-b82a-02e41a1f867a" />

# Api Routes
<img width="1355" height="347" alt="image" src="https://github.com/user-attachments/assets/5591da5e-0e83-47dc-a78e-071af4a315f5" />

# Full version

<img width="9128" height="4367" alt="visily-multicomponents" src="https://github.com/user-attachments/assets/c1941968-156c-4b1d-ab68-084786f1cc2d" />



