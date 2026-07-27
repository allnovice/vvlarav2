# Reports Module (v1)

> Initial implementation of the CMMS Reports module using Laravel, Inertia, Vue, and Tailwind.

---

## Overview

The Reports module provides filtered views of CMMS data with CSV export support.

Current implementation focuses on the **Asset Inventory Report** and is designed to be easily extended for additional report types.

---

## Features

### Asset Inventory Report

- Search assets
- Filter by:
  - Department
  - Location
  - Type
  - Status
- Paginated asset table
- CSV export
- CSV export respects all active filters
- Reuses existing AssetTable component

---

## Backend

### Controller

`ReportController`

Methods:

- `index()`
  - Displays Asset Inventory report
  - Loads filters
  - Returns paginated assets

- `exportCsv()`
  - Generates downloadable CSV
  - Uses streamed response
  - Applies the same filters as the report

### Shared Query

Filtering logic is centralized in:

```php
buildAssetQuery(Request $request)
```

Benefits:

- No duplicated filtering code
- Shared by:
  - `index()`
  - `exportCsv()`
- Easy to extend for future exports

---

## Frontend

### Page

```
resources/js/Pages/Reports/Index.vue
```

Responsibilities:

- Display filters
- Display asset table
- Handle export

---

### Components

#### ReportToolbar.vue

Provides:

- Search
- Department filter
- Location filter
- Type filter
- Status filter
- Export CSV button

Events:

```text
update:filters
export
```

---

### Reused Components

Instead of creating a new table, Reports reuses:

- AssetTable
- AssetPagination

This keeps UI consistent with the Assets module.

---

## Export

Current export format:

- CSV

Implementation:

- Native Laravel streamed response
- No third-party packages required

Advantages:

- Fast
- Memory efficient
- Supports large datasets

CSV contains:

- Property Number
- Type
- Description
- Status
- Department
- Location
- Assigned To

(More columns can be added later.)

---

## Routes

Current:

```php
GET /reports
GET /reports/export/csv
```

---

## Current Folder Structure

```
resources/
└── js/
    └── Pages/
        └── Reports/
            └── Index.vue
```

Only one report currently exists, so a single page is sufficient.

---

# Future Expansion

When additional reports are added, restructure to:

```
Reports/
├── AssetInventory/
│   └── Index.vue
├── AssetVerification/
│   └── Index.vue
├── MaintenanceSchedule/
│   └── Index.vue
├── MaintenanceHistory/
│   └── Index.vue
├── RepairRequests/
│   └── Index.vue
├── WorkOrders/
│   └── Index.vue
├── AssetChanges/
│   └── Index.vue
└── UserActivity/
    └── Index.vue
```

Routes would then become:

```
/reports/assets
/reports/asset-verification
/reports/maintenance-schedule
/reports/maintenance-history
/reports/repair-requests
/reports/work-orders
/reports/asset-changes
/reports/user-activity
```

---

## Design Decisions

- Reuse existing AssetTable component
- Keep filtering logic in one place
- Stream CSV instead of building files in memory
- Separate export functionality from report rendering
- Build reports as independent modules
- Delay folder restructuring until multiple reports exist

---

## Roadmap

### v1 (Completed)

- Asset Inventory Report
- Search
- Department filter
- Location filter
- Type filter
- Status filter
- CSV export
- Shared query builder

### v1.1

- Export all asset fields
- Better CSV filenames
- Export selected columns

### v1.2

- Printable report layout
- PDF export

### v2

- Excel (.xlsx) export (when PHP 8.5 dependency support is available)

### Future Reports

- Asset Verification
- Maintenance Schedule
- Maintenance History
- Repair Requests
- Work Orders
- Asset Changes
- User Activity

---

## Status

**Asset Inventory Report v1 Complete**

- Functional filtering
- Functional search
- Functional CSV export
- Ready for future report expansion
