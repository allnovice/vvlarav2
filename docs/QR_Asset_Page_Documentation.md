# QR Asset Page (`QrShow.vue`)

## Overview

Implemented a dedicated mobile-friendly QR landing page for technicians.

### Route Architecture

    /assets/{asset}/qr

-   Opens the QR print page (`PrintQr.vue`).
-   Generates the QR code.

```{=html}
<!-- -->
```
    /assets/qr/{asset}

-   Opens `QrShow.vue`.
-   Intended as the page displayed after scanning the QR code.

The QR code now points to:

    route('assets.qr', $asset)

instead of the full asset page.

## Controller

Added:

-   `AssetController@showQr()`

Loads only the data required by the QR page:

-   Asset
-   History
-   Maintenance Schedule

Example:

``` php
$asset->load([
    'history',
    'maintenanceSchedule',
]);
```

## QrShow.vue

Current layout:

-   Brand + Model
-   Property Number
-   Assigned To
-   Verification
    -   Verified Date
    -   Next Verification Due
-   Maintenance
    -   Last Maintenance
    -   Next Due
-   Complete Asset History
-   "View Full Asset" link

## History

Uses the existing `asset.history` relationship.

Each entry displays:

-   Type
-   Performed Date
-   Title
-   Description (if available)
-   Remarks (if available)

History is intentionally **not limited**, allowing technicians to review
the complete maintenance record from the QR page.

## Design Goals

-   Mobile-first
-   Fast loading
-   Text-focused
-   Minimal UI
-   Reuses existing backend relationships
-   Keeps the full Asset page separate from the QR experience

## Git Commit

``` text
feat(qr): add mobile-friendly QR asset page with maintenance history
```
