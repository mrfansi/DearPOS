# Document Management

### Document Categories Table (`document_categories`)

-   `id` - UUID, Primary Key
-   `name` - String(100)
-   `description` - Text, Nullable
-   `parent_id` - UUID, Nullable, Foreign Key to document_categories
-   `path` - String(500)
-   `level` - Integer
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Documents Table (`documents`)

-   `id` - UUID, Primary Key
-   `category_id` - UUID, Foreign Key to document_categories
-   `title` - String(200)
-   `description` - Text, Nullable
-   `file_name` - String(255)
-   `file_path` - String(500)
-   `file_type` - String(50)
-   `file_size` - Integer
-   `mime_type` - String(100)
-   `version` - String(20)
-   `status` - Enum ['draft', 'published', 'archived']
-   `is_template` - Boolean, Default false
-   `created_by` - UUID, Foreign Key to users
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Document Versions Table (`document_versions`)

-   `id` - UUID, Primary Key
-   `document_id` - UUID, Foreign Key to documents
-   `version` - String(20)
-   `file_name` - String(255)
-   `file_path` - String(500)
-   `file_size` - Integer
-   `changes` - Text, Nullable
-   `created_by` - UUID, Foreign Key to users
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Document Templates Table (`document_templates`)

-   `id` - UUID, Primary Key
-   `name` - String(100)
-   `description` - Text, Nullable
-   `category_id` - UUID, Foreign Key to document_categories
-   `file_name` - String(255)
-   `file_path` - String(500)
-   `file_type` - String(50)
-   `content` - Text
-   `variables` - JSON, Nullable
-   `is_active` - Boolean, Default true
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Document Shares Table (`document_shares`)

-   `id` - UUID, Primary Key
-   `document_id` - UUID, Foreign Key to documents
-   `shared_by` - UUID, Foreign Key to users
-   `shared_with` - UUID, Foreign Key to users
-   `permission` - Enum ['view', 'edit', 'admin']
-   `expires_at` - Timestamp, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Document Access Logs Table (`document_access_logs`)

-   `id` - UUID, Primary Key
-   `document_id` - UUID, Foreign Key to documents
-   `user_id` - UUID, Foreign Key to users
-   `action` - Enum ['view', 'download', 'print', 'share', 'edit']
-   `ip_address` - String(45)
-   `user_agent` - String(255)
-   `created_at` - Timestamp

### Document Comments Table (`document_comments`)

-   `id` - UUID, Primary Key
-   `document_id` - UUID, Foreign Key to documents
-   `user_id` - UUID, Foreign Key to users
-   `parent_id` - UUID, Nullable, Foreign Key to document_comments
-   `content` - Text
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Document Tags Table (`document_tags`)

-   `id` - UUID, Primary Key
-   `name` - String(50)
-   `color` - String(7), Nullable # Hex color code
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Document Tag Relations Table (`document_tag_relations`)

-   `id` - UUID, Primary Key
-   `document_id` - UUID, Foreign Key to documents
-   `tag_id` - UUID, Foreign Key to document_tags
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Document Workflows Table (`document_workflows`)

-   `id` - UUID, Primary Key
-   `name` - String(100)
-   `description` - Text, Nullable
-   `steps` - JSON # Array of workflow steps
-   `is_active` - Boolean, Default true
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Document Workflow Instances Table (`document_workflow_instances`)

-   `id` - UUID, Primary Key
-   `workflow_id` - UUID, Foreign Key to document_workflows
-   `document_id` - UUID, Foreign Key to documents
-   `current_step` - Integer
-   `status` - Enum ['active', 'completed', 'cancelled']
-   `started_at` - Timestamp
-   `completed_at` - Timestamp, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Document Workflow Actions Table (`document_workflow_actions`)

-   `id` - UUID, Primary Key
-   `instance_id` - UUID, Foreign Key to document_workflow_instances
-   `step` - Integer
-   `action` - Enum ['approve', 'reject', 'review', 'comment']
-   `user_id` - UUID, Foreign Key to users
-   `comments` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Document Audits Table (`document_audits`)

-   `id` - UUID, Primary Key
-   `auditable_type` - String(100) # documents, templates, workflows, etc.
-   `auditable_id` - UUID
-   `event` - Enum ['created', 'updated', 'deleted', 'shared', 'accessed']
-   `old_values` - JSON, Nullable
-   `new_values` - JSON, Nullable
-   `user_id` - UUID, Foreign Key to users
-   `created_at` - Timestamp
