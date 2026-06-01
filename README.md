# Overview 
This document lists a minimal, human-readable set of system requirements for our 24‑hour v2 finance management web app .

## Plan Details

1. **Data backup & restore (MUST)**
   - Users can export all their data as a JSON file (transactions, recurring                 transactions, goals).
   - Users can import data only from the app’s exported format.
   - The system validates imported data structure before applying changes.


2. **Transaction categories (MUST)**
    - Each transaction is assigned a category.
    - Supported categories include: Food, Transport, Bills, Needs, Wants.
    - Categories are stored in a structured format (enum or table) to allow future extensibility.

3. **Goals system (MUST)**
     - Users can define a financial goal with:
     - value
     - period (daily or weekly or monthly)
   - The current goal is displayed on the dashboard with progress tracking.
   - A simple history of past goals is available with status : achieved, failed.
   - in progress goal shouldn't be displayed in history
   - if a goal is closed and no new goals created , automatically duplicate the current goal for tomorrow and set the current to failed.


4. **Server-side pagination (MUST)**
   - all tables data are fetched using server-side pagination .
   - Pagination ensures performance scalability as data grows.

5. **Dashboard improvements (SHOULD)**
   - Display spending distribution by category using a simple chart (e.g., pie chart).
   - Highlight top spending category.
   - Provide basic financial insights (e.g. income vs expense).

6. **Usability improvements (SHOULD)**
   - Forms use smart defaults:
     - Default date is today
     - Last used category is preselected
   - Reduce friction when adding transactions (minimal input effort).
   - Support quick and efficient data entry.

7. **Data deletion (SHOULD)**
   - user should be able to start fresh by removing his account.

8. **Optional but recommended (MAY)**
    - Use of single default currency (e.g., USD) to avoid currency conversion complexity.
    - Basic export of transactions (CSV) may be added only if time remains.

### ### Acceptance criteria (top priorities)
- A user can export their data and successfully restore it using the import feature.
- Transactions include categories and can be used for breakdown and analysis.
- The system handles large numbers of transactions efficiently via pagination.
- A user can set a goal, track its progress, and view past goals.
- The app remains fast, usable, and deployable within the 24-hour timebox.


# User Journey map
<img width="7006" height="2633" alt="visily-user-journey-map" src="https://github.com/user-attachments/assets/af6440a1-6adc-4f5d-9384-da07b64905f5" />

# Data Models
<img width="1197" height="1459" alt="visily-data-models" src="https://github.com/user-attachments/assets/2afbf59e-218d-4345-9f76-46d4bf9d619c" />

# Api Routes
<img width="2144" height="1370" alt="visily-api-routes" src="https://github.com/user-attachments/assets/cefd926f-0695-4f98-b69b-f1fb6a1330bb" />

# Timeline expectations 
<img width="9128" height="1339" alt="visily-timeline-expectations" src="https://github.com/user-attachments/assets/551400bc-efa6-45c6-a8a6-9fffd290adc4" />

# Full version
<img width="9128" height="6547" alt="visily-multicomponents(1)" src="https://github.com/user-attachments/assets/4b326743-e685-4770-b552-772909910787" />




