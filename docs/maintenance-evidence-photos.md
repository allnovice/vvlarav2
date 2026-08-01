# Maintenance Evidence Photos

## Overview

Implemented support for attaching photo evidence to each preventive maintenance event.

Unlike Asset Photos, maintenance evidence is **not** part of the asset approval workflow. These photos are stored immediately after a maintenance record is successfully created and are linked to the corresponding Asset History entry.

---

## Features

- Added maintenance remarks.
- Added support for uploading multiple maintenance evidence photos.
- Reused the existing `ImageService` for thumbnail generation.
- Created a dedicated `maintenance_photos` table.
- Linked maintenance photos to `AssetHistory`.
- Displayed maintenance thumbnails in the Asset History card.
- Reused the existing `ImageModal` component for viewing full-size images.

---

## Database

### New Table

`maintenance_photos`

| Column | Description |
|---------|-------------|
| id | Primary key |
| asset_history_id | References the Asset History entry |
| photo_path | Original image path |
| photo_thumb_path | Generated thumbnail path |
| created_at | Timestamp |
| updated_at | Timestamp |

Relationship:

```
AssetHistory
    └── hasMany(MaintenancePhoto)
```

```
MaintenancePhoto
    └── belongsTo(AssetHistory)
```

---

## Upload Flow

```
Perform Maintenance
        │
        ├── Frequency
        ├── Remarks
        ├── Evidence Photos
        │
        ▼
MaintenanceExecutionController
        │
        ├── Update maintenance schedule
        ├── Create AssetHistory
        ├── Store original images
        ├── Generate thumbnails
        └── Save MaintenancePhoto records
```

---

## Image Storage

Original images:

```
storage/app/public/maintenance/
```

Generated thumbnails:

```
storage/app/public/maintenance/thumbs/
```

Thumbnail generation uses the existing:

```
App\Services\ImageService
```

No duplicate thumbnail logic was created.

---

## Backend Changes

### MaintenanceExecutionController

Added:

- Validation for uploaded photos.
- `forceFormData` upload support.
- Creation of `AssetHistory`.
- Upload loop for maintenance photos.
- Thumbnail generation.
- Creation of `MaintenancePhoto` records.

---

## Models

### MaintenancePhoto

Fillable:

- asset_history_id
- photo_path
- photo_thumb_path

Relationship:

```
belongsTo(AssetHistory)
```

### AssetHistory

Added:

```
photos()
```

```
hasMany(MaintenancePhoto)
```

---

## Asset Loading

Updated AssetController:

From:

```
history
```

To:

```
history.photos
```

This eager loads maintenance photos together with asset history.

---

## Frontend

### PerformMaintenanceModal

Added:

- Remarks field
- Multiple image selection
- `photos` property in the Inertia form
- Multipart upload (`forceFormData`)

### HistoryCard

Added:

- Display of maintenance evidence thumbnails
- Reused existing `ImageModal`

Example:

```vue
<ImageModal
    v-for="photo in entry.photos"
    :key="photo.id"
    :src="`/storage/${photo.photo_path}`"
    :thumbnail-src="`/storage/${photo.photo_thumb_path}`"
    thumbnail-class="h-20 w-20 rounded-lg border object-cover"
/>
```

---

## Design Decisions

Maintenance evidence is linked to **Asset History**, not the maintenance schedule.

Benefits:

- Every maintenance event has its own evidence.
- Remarks and photos remain together.
- Better audit trail.
- Supports multiple maintenance events over time.
- Keeps the maintenance schedule table clean.

---

## Reused Components

No new image handling code was created.

Existing components reused:

- `ImageService`
- `ImageModal`

This keeps image processing and viewing consistent across the CMMS.

---

## Testing

Verified:

- Maintenance record creation
- Remarks saved
- Multiple image upload
- Thumbnail generation
- Database records created
- History relationship loading
- Thumbnail display
- Full-size image viewing

---

## Notes

This implementation establishes a complete maintenance evidence workflow while reusing the application's existing image infrastructure, minimizing duplicated code and keeping the audit trail tied to each maintenance event.
