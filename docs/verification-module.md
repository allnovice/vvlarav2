Verification Module

Overview

The Verification Module provides a controlled workflow for physically verifying organizational assets. It ensures that asset records remain accurate by requiring verification requests, approval, and periodic re-verification.

---

Objectives

- Verify that an asset physically exists.
- Maintain an audit trail of every verification.
- Automatically schedule the next verification after approval.
- Provide management with verification statistics and reports.

---

Verification Workflow

1. User submits an asset verification request.
2. Supporting photos are uploaded.
3. Request enters Pending status.
4. Authorized approver reviews the request.
5. If approved:
   - Verification history is recorded.
   - Asset verification status is updated.
   - Next verification date is scheduled six months later.
6. If rejected:
   - Asset remains unchanged.
   - Reviewer remarks are stored.

---

Database Design

assets

Stores the current verification state.

Verification Fields

- verified_at
- verified_by
- last_verified_at
- next_verification_due

These fields represent only the latest approved verification.

---

asset_verifications

Stores the complete verification history.

Each record contains:

- Asset
- Requesting user
- Approval status
- Reviewer
- Review date
- Attachment
- Remarks

This table serves as the audit trail.

---

Verification Schedule

Current policy:

- Initial verification begins the schedule.
- Every approved verification schedules the next verification 6 months later.

Example:

Verification Approved

↓

Last Verified: July 31, 2026

↓

Next Verification Due: January 31, 2027

---

Verification Dashboard

KPI Cards

- Total Assets
- Never Verified
- Due (Next 30 Days)
- Overdue
- Coverage

Cards are clickable and filter the asset table.

---

Verification Table

Displays:

- Property Number
- Type
- Brand
- Model
- Next Verification Due
- Days Remaining

Supports filtering from KPI cards.

---

Verification Trend Chart

Displays verification activity for the last 12 months.

Data source:

- asset_verifications.reviewed_at

Purpose:

- Monitor verification workload.
- Identify activity trends.
- Support reporting.

---

Demo Seeder

Command:

sail artisan cmms:seed-verification-demo

Generates realistic demo verification data.

Current distribution:

- Never Verified: 15
- Overdue: 18
- Due (30 Days): 37
- Verified: Remaining assets

Also creates matching verification history records.

---

Reset Command

sail artisan cmms:seed-verification-demo --reset

Resets:

- Asset verification fields
- Verification history

Intended for development only.

The command is protected from execution in the production environment.

---

Current Features

- Verification request workflow
- Approval process
- Six-month verification scheduling
- Verification history
- Verification dashboard
- KPI cards
- Interactive filtering
- Monthly verification trend
- Demo data generator
- Reset utility

---

Future Enhancements

- Coverage progress bar
- Excel/PDF reports
- Email and in-app notifications
- Department and location analytics
- Verification calendar
- Technician performance metrics
- Configurable verification intervals

---

Version

Version 1

Status: Complete and ready for production integration.
