## ADDED Requirements

### Requirement: Hero Slider Management System
The system SHALL provide comprehensive hero slider management with CRUD operations for content managers and admins.

#### Scenario: Create new hero slide
- **WHEN** a content manager or admin creates a new hero slide
- **THEN** they can enter name, upload image, set order, and toggle active status
- **AND** the hero slide is saved with a unique slug for identification
- **AND** the image is stored via Spatie MediaLibrary with automatic conversions (thumb, medium, large)

#### Scenario: Edit existing hero slide
- **WHEN** a content manager or admin edits an existing hero slide
- **THEN** they can modify name, replace image, update order, and toggle active status
- **AND** the changes are saved with a timestamp of the last modification
- **AND** the old image is replaced and removed from storage

#### Scenario: Delete hero slide
- **WHEN** a content manager or admin deletes a hero slide
- **THEN** the hero slide is removed from the system
- **AND** the associated media (images) are deleted from storage
- **AND** the deletion is logged for audit purposes

#### Scenario: Toggle active/inactive status
- **WHEN** a content manager toggles a hero slide's active status
- **THEN** only active hero slides are displayed on the frontend landing page
- **AND** inactive hero slides are still visible in the admin interface
- **AND** the status change is reflected immediately

#### Scenario: Manage hero slide order
- **WHEN** a content manager sets a numeric order value for hero slides
- **THEN** hero slides are displayed on the frontend in ascending order
- **AND** slides with the same order value are sorted alphabetically by name

### Requirement: Hero Slider Interface
The system SHALL provide a modern admin interface for managing hero slides.

#### Scenario: Content manager views hero slides list
- **WHEN** a content manager or admin views the hero slides page
- **THEN** they see a modern data table with hero name, thumbnail preview, order, and active status
- **AND** the table supports sorting by order, name, and created date
- **AND** each row has quick action buttons (edit, delete, toggle active)

#### Scenario: Create/edit hero slide form
- **WHEN** a content manager accesses the hero create/edit form
- **THEN** they see a modern form layout with image upload field
- **AND** the image upload supports drag & drop functionality
- **AND** an image preview is shown after upload or for existing heroes
- **AND** validation errors are displayed inline with helpful messages

#### Scenario: Bulk actions on hero slides
- **WHEN** a content manager selects multiple hero slides
- **THEN** they can activate or deactivate them in bulk
- **AND** they can delete multiple hero slides at once
- **AND** a confirmation dialog is shown for bulk delete operations

### Requirement: Hero Slider Permissions
The system SHALL enforce permission-based access control for hero management.

#### Scenario: Content manager accesses hero management
- **WHEN** a user with content_manager role logs in
- **THEN** they have access to hero slide management
- **AND** they can create, edit, and delete hero slides

#### Scenario: Admin accesses hero management
- **WHEN** a user with admin role logs in
- **THEN** they have full access to all hero management features
- **AND** they can perform all CRUD operations on hero slides

#### Scenario: Regular user attempts to access hero management
- **WHEN** a regular user attempts to access hero admin pages
- **THEN** they are denied access with a 403 Forbidden error
- **AND** the hero management menu items are not visible to them

