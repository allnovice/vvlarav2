# Maintenance Schedule

## Overview

The Maintenance Schedule module allows administrators to assign a preventive maintenance schedule to an asset. Each asset can have only one active schedule.

## Features

- Create a maintenance schedule
- View schedule details
- Edit an existing schedule
- Delete a schedule
- Automatic next due date calculation
- Supports:
  - Weekly
  - Monthly
  - Quarterly
  - Semi-Annual
  - Annual
  - Custom interval (days)
- Optional maintenance notes

## Database

### Table

`maintenance_schedules`

| Column | Description |
|--------|-------------|
| asset_id | Related asset |
| maintenance_date | Initial maintenance date |
| frequency | Schedule interval |
| custom_interval | Number of days when using Custom |
| next_due_date | Automatically calculated next maintenance |
| notes | Maintenance instructions |
| created_by | User who created the schedule |
| updated_by | Last user who modified the schedule |

## Relationships

```
Asset
    └── hasOne MaintenanceSchedule
```

## Workflow

1. Open an Asset.
2. Create a maintenance schedule.
3. The system calculates the next due date.
4. Once saved, the schedule is displayed as a summary card.
5. The schedule can be edited or deleted.

## Current Limitations

- One schedule per asset.
- No maintenance execution yet.
- No maintenance history yet.
- No notifications yet.

## Planned Enhancements

- Maintenance work queue
- Perform maintenance
- Maintenance history
- Technician assignments
- Dashboard widgets
- Email/in-app reminders
- Calendar view
