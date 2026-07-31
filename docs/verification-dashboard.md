# Verification Dashboard

## Overview

The Verification Dashboard provides an executive summary of recurring asset verification activities. It gives managers and technicians a quick view of verification status, compliance, and upcoming work through KPI cards, charts, and summary tables.

---

# Objectives

- Monitor overall verification compliance.
- Identify assets requiring verification.
- Track verification trends.
- Display upcoming verification activities.
- Provide a foundation for future reporting and analytics.

---

# Dashboard Components

## KPI Cards

### Total Assets

Displays the total number of assets in the system.

Calculation:

- COUNT(assets)

---

### Due for Verification

Displays assets whose next verification date is today or earlier.

Calculation:

- next_verification_due <= today

---

### Overdue

Displays assets whose next verification date has already passed.

Calculation:

- next_verification_due < today

---

### Verification Coverage

Displays the percentage of assets currently considered up to date.

Calculation:

Coverage = (Verified Assets / Total Assets) × 100

Where:

Verified Assets are assets with:

- next_verification_due >= today

---

# Trend Chart

## Monthly Verifications

Displays the number of approved verifications performed each month during the current year.

Technology:

- Chart.js
- vue-chartjs

Current query:

- Group AssetVerification records by month
- Count verifications per month

Months without data are displayed as zero.

---

# Upcoming Verifications

Displays the next assets requiring verification.

Current fields:

- Property Number
- Type
- Brand
- Model
- Next Verification Due

Results are ordered by:

- next_verification_due ASC

Maximum rows:

- 10

---

# Backend

## Controller

VerificationController@index

Responsibilities:

- Calculate dashboard KPIs
- Calculate coverage
- Retrieve monthly verification statistics
- Retrieve upcoming verification assets
- Pass data to Inertia

---

# Database Fields

Assets table:

- verified_at
- verified_by
- last_verified_at
- next_verification_due

Verification schedule:

- Fixed six-month verification cycle

---

# Frontend Components

Pages

- resources/js/Pages/Verification/Index.vue

Components

- VerificationStatCard.vue
- VerificationTrendChart.vue
- DueSoonTable.vue

---

# Current Workflow

Asset Verification

↓

Approval

↓

last_verified_at updated

↓

next_verification_due = last_verified_at + 6 months

↓

Dashboard automatically reflects new status

---

# Future Enhancements

## Dashboard

- Clickable KPI cards
- Department summary
- Location summary
- Technician summary
- Verification heatmap

## Tables

- Days Remaining column
- Color-coded due status
- Search
- Sorting
- Pagination

## Charts

- Verifications by Department
- Verifications by Location
- Monthly Coverage Trend
- Verification Completion Rate

## Reports

- Export to Excel
- Export to PDF
- Printable Verification Report

---

# Version

Version 1.0

Features included:

- KPI cards
- Monthly verification chart
- Upcoming verification table
- Coverage calculation
- Six-month recurring verification support
