Asset Parent Linking

Overview

The Asset Parent Linking feature allows related ICT assets to be associated in a parent-child relationship. This enables the CMMS to represent a complete workstation or equipment set while maintaining each component as an individual asset.

Examples include:

- Desktop Computer → Monitor
- Desktop Computer → UPS
- Desktop Computer → Keyboard
- Desktop Computer → Mouse
- Desktop Computer → Webcam
- Desktop Computer → Printer (if permanently assigned)

Each child asset remains independently tracked for maintenance, verification, history, and lifecycle management.

---

Objectives

- Group related assets into a logical workstation.
- Preserve individual asset records and histories.
- Improve maintenance and inventory tracking.
- Prevent duplicate ownership records.
- Prepare the system for future workstation visualization and reporting.

---

Database Design

The relationship is implemented using a self-referencing foreign key.

Column| Description
"parent_asset_id"| References the parent asset. "NULL" indicates the asset has no parent.

Relationship:

- One parent asset may have many child assets.
- A child asset belongs to only one parent.

---

User Interface

The Asset Details page includes a Link Asset action.

The button is displayed only to users with approval privileges.

The button is disabled when:

- the asset is already linked to a parent; or
- the asset already has child assets (is acting as a parent).

Selecting the button opens a search dialog where the user can locate the desired parent asset.

---

Parent Search

The search dialog supports searching by:

- Property Number
- Brand
- Model

Matching assets are displayed dynamically for selection.

---

Linking Process

1. Open the Asset Details page.
2. Select Link Asset.
3. Search for the desired parent asset.
4. Select the parent.
5. Confirm the link.

The selected asset becomes the parent while the current asset becomes its child.

---

Authorization

Parent linking is protected by middleware.

Only users that satisfy:

"User::canApprove()"

are permitted to perform the operation.

The same permission is also used by the frontend to hide the Link Asset button from unauthorized users.

This provides both:

- User Interface security
- Server-side authorization

---

Business Rules

- A child asset may belong to only one parent.
- A parent may contain multiple child assets.
- Parent assets cannot themselves be linked as children while they already have child assets.
- Existing maintenance records, verification history, photos, and asset history remain unchanged after linking.

---

Current Implementation

Implemented:

- Parent asset search endpoint
- Parent linking endpoint
- Parent-child database relationship
- Link Asset modal
- Dynamic asset search
- Middleware authorization
- Frontend permission-based button visibility

---

Future Enhancements

Planned improvements include:

- Approval workflow for parent linking requests.
- Ability to unlink assets.
- Parent-child hierarchy visualization.
- Automatic workstation summary view.
- Bulk linking during asset import.
- Validation to prevent circular parent-child relationships.
