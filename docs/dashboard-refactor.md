# Dashboard Refactor

## Goal

Refactor the dashboard into reusable layout components before redesigning the UI.

## Components

- MainLayout
    - Application shell (navbar, footer, etc.)

- ContentLayout
    - Centers page content and controls page width/padding.

- DashboardSection
    - Groups related dashboard rows vertically.

- DashboardRow
    - Creates a responsive two-column layout.

- DashboardColumn
    - Wraps a widget inside a row and allows equal-height columns.

- DashboardWidget
    - Shared card component (border, shadow, padding, title).

## Current Layout

Dashboard
├── Section
│   ├── Row
│   │   ├── Column → Hero
│   │   └── Column → Pending Tasks
│   └── Row
│       ├── Column → Maintenance Summary
│       └── Column → About
└── Section
    └── Recent Activity

## Status

- Completed:
    - Modular dashboard layout.
    - Responsive two-column rows.
    - Equal-height cards within each row.

- Next:
    - Redesign the dashboard widgets and overall appearance.
