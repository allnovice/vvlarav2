# QR Asset System

## Overview

Implemented a QR-based asset identification system consisting of:

- QR Asset page for technicians.
- Bulk QR label generation and printing.
- Mobile-friendly asset lookup after scanning.

## Routes

### QR Asset

    /assets/qr/{asset}

Displays the mobile-friendly asset information page after scanning a QR code.

### QR Label Printing

    /qr-labels

Browse, search, and select multiple assets for QR label printing.

### QR Label Preview

    /qr-labels/print

Displays a printable preview of the selected QR labels.

## QR Asset Page

Displays:

- Brand + Model
- Property Number
- Assigned To
- Verification
    - Verified Date
    - Next Verification Due
- Maintenance
    - Last Maintenance
    - Next Due
- Complete Asset History
- View Full Asset link

History is intentionally **not limited**, allowing technicians to review the complete maintenance record directly from the QR page.

## QR Label Printing

Features:

- Search assets
- Multi-select assets
- Persistent print queue using Local Storage
- Selection survives page changes and browser refresh
- Remove assets from the print queue
- Bulk QR label preview
- Browser-native printing (`window.print()`)

Labels are generated in a compact printable grid suitable for adhesive sticker paper.

## Design Goals

- Mobile-first QR experience
- Lightweight asset lookup
- Bulk QR label printing
- Minimal user interaction
- Reuse existing asset relationships
- Browser-managed printing without external PDF generation

## Git Commit

```text
feat(qr): add bulk QR label printing and mobile QR asset page
```