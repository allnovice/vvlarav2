# Activity Logging

## Overview

A centralized activity logging system records important user actions across the CMMS for auditing, accountability, and troubleshooting.

## Architecture

- `activity_logs` table stores all activity records.
- `ActivityLogger` service centralizes logging logic.
- `log()` is the generic logger for all modules.
- `logAsset()` is a helper for asset-related events.

## Asset Events Implemented

### Submission
- Submit Create
- Submit Update
- Submit Delete

### Approval
- Approve Create
- Approve Update
- Approve Delete
- Reject

Each log records:
- User
- Module
- Action
- Description
- Subject Type
- Subject ID
- Timestamp
- Properties (JSON)

Asset properties include:
- `asset_change_id`
- `property_number`
- `request_action`

## Action Constants

`ActivityLogger` defines constants for asset actions to avoid hard-coded strings and ensure consistency.

## Current UI

The Activity Logs page displays:
- Date/Time
- User
- Module
- Action
- Description

## Future Enhancements

- View activity details
- Link logs to Asset Changes
- View field-by-field changes
- Search
- Filter by module
- Filter by action
- Filter by user
- Filter by date range
- Export logs

## TODO

### Authentication
- Login
- Logout

### Users
- User approval
- User rejection
- Role changes

### Assets
- Verification
- Photo approvals

### Maintenance
- Create
- Update
- Complete

### Repair Requests
- Submit
- Approve
- Reject
- Complete

### System
- Settings changes
- Report exports
