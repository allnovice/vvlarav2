# QR Label Printing

## Overview

Implemented a bulk QR label printing workflow for assets.

## Features

- New QR Labels page.
- Search assets.
- Select multiple assets using checkboxes.
- Print Selected action.
- Generates QR codes for selected assets.
- Preview page displays labels in a printable grid.
- Each label is fixed at 1 × 1 inch.
- QR code links to the lightweight asset QR page (`/assets/qr/{asset}`).
- Browser print (`window.print()`) used instead of PDF/DOCX generation.
- Paper size is selected in the browser print dialog (recommended: ISO A4).

## Routes

- `/qr-labels`
- `/qr-labels/print`

## Notes

- Preview page is intended as a print preview rather than an interactive page.
- Browser handles page size, margins, and pagination.
- Future enhancements:
  - Select All
  - Print Queue
  - PDF/DOCX export
  - Pre-cut label templates
