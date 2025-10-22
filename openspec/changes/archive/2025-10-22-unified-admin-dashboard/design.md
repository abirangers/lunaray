## Context
The current admin dashboard is designed only for content managers, but we need to support both content managers and admins with different permission levels. We need a unified dashboard that shows different content and navigation based on user roles while maintaining a consistent UI/UX experience.

## Goals / Non-Goals
- **Goals**: 
  - Unified admin dashboard for both content managers and admins
  - Role-based navigation (completely hidden items, not disabled)
  - Dynamic dashboard content based on user permissions
  - Consistent branding and UI/UX for all roles
  - Maintain existing functionality for content managers
- **Non-Goals**: 
  - Separate dashboards for different roles
  - Disabled/grayed out menu items
  - Different styling or branding per role

## Decisions
- **Decision**: Use conditional rendering with @can directives for both sidebar and dashboard content
- **Alternatives considered**: Separate controllers/views per role, but this would duplicate code and maintenance overhead
- **Rationale**: Single codebase is easier to maintain, consistent UI/UX, and follows DRY principles

- **Decision**: Completely hide navigation items for content managers (not disabled)
- **Alternatives considered**: Disabled items with tooltips, but this creates confusion about access
- **Rationale**: Cleaner UI, no confusion about what users can access

- **Decision**: Add admin-specific cards to existing dashboard layout
- **Alternatives considered**: Separate dashboard sections, but this would break the unified experience
- **Rationale**: Maintains consistent layout while adding role-specific functionality

## Risks / Trade-offs
- **Risk**: Dashboard becomes cluttered with too many cards for admins
- **Mitigation**: Use responsive grid layout and consider collapsible sections

- **Risk**: Performance impact from loading additional data for admins
- **Mitigation**: Use efficient queries and consider caching for admin-specific data

- **Risk**: Complex conditional logic in views
- **Mitigation**: Keep logic in controllers, use simple @can directives in views

## Migration Plan
1. Update ContentManagerController to provide role-based data
2. Update admin layout sidebar with conditional navigation
3. Update dashboard view with conditional cards
4. Test with both content manager and admin users
5. Verify all permissions work correctly

## Open Questions
- Should we add any additional admin-specific metrics beyond user count and system health?
- Do we need any admin-specific quick actions or shortcuts?
- Should we consider adding admin-specific widgets or charts?
