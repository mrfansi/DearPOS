# Analytics & Reporting

### Report Definitions Table (`report_definitions`)

-   `id` - UUID, Primary Key
-   `name` - String(100)
-   `code` - String(20), Unique
-   `description` - Text, Nullable
-   `category` - Enum ['sales', 'inventory', 'finance', 'hr', 'operations', 'custom']
-   `query` - Text
-   `parameters` - JSON, Nullable
-   `output_format` - Enum ['table', 'chart', 'pivot', 'dashboard']
-   `chart_type` - Enum ['line', 'bar', 'pie', 'scatter', 'area'], Nullable
-   `is_system` - Boolean, Default false
-   `is_public` - Boolean, Default false
-   `created_by` - UUID, Foreign Key to users
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Report Schedules Table (`report_schedules`)

-   `id` - UUID, Primary Key
-   `report_id` - UUID, Foreign Key to report_definitions
-   `name` - String(100)
-   `frequency` - Enum ['daily', 'weekly', 'monthly', 'quarterly', 'yearly']
-   `day_of_week` - Integer, Nullable # 0-6, 0 = Sunday
-   `day_of_month` - Integer, Nullable # 1-31
-   `time_of_day` - Time
-   `parameters` - JSON, Nullable
-   `recipients` - JSON # Array of email addresses
-   `is_active` - Boolean, Default true
-   `last_run` - Timestamp, Nullable
-   `next_run` - Timestamp, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Report Executions Table (`report_executions`)

-   `id` - UUID, Primary Key
-   `report_id` - UUID, Foreign Key to report_definitions
-   `schedule_id` - UUID, Nullable, Foreign Key to report_schedules
-   `user_id` - UUID, Nullable, Foreign Key to users
-   `parameters` - JSON, Nullable
-   `status` - Enum ['queued', 'running', 'completed', 'failed']
-   `start_time` - Timestamp
-   `end_time` - Timestamp, Nullable
-   `duration_seconds` - Integer, Nullable
-   `row_count` - Integer, Nullable
-   `error_message` - Text, Nullable
-   `output_path` - String(500), Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Dashboards Table (`dashboards`)

-   `id` - UUID, Primary Key
-   `name` - String(100)
-   `description` - Text, Nullable
-   `layout` - JSON # Dashboard layout configuration
-   `is_system` - Boolean, Default false
-   `is_public` - Boolean, Default false
-   `created_by` - UUID, Foreign Key to users
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Dashboard Widgets Table (`dashboard_widgets`)

-   `id` - UUID, Primary Key
-   `dashboard_id` - UUID, Foreign Key to dashboards
-   `report_id` - UUID, Foreign Key to report_definitions
-   `name` - String(100)
-   `type` - Enum ['chart', 'metric', 'table', 'custom']
-   `config` - JSON # Widget specific configuration
-   `position` - JSON # {x, y, width, height}
-   `refresh_interval` - Integer, Nullable # in seconds
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### KPI Definitions Table (`kpi_definitions`)

-   `id` - UUID, Primary Key
-   `name` - String(100)
-   `code` - String(20), Unique
-   `description` - Text, Nullable
-   `category` - Enum ['sales', 'inventory', 'finance', 'hr', 'operations']
-   `calculation_method` - Text
-   `target_type` - Enum ['value', 'percentage', 'ratio']
-   `frequency` - Enum ['daily', 'weekly', 'monthly', 'quarterly', 'yearly']
-   `is_active` - Boolean, Default true
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### KPI Targets Table (`kpi_targets`)

-   `id` - UUID, Primary Key
-   `kpi_id` - UUID, Foreign Key to kpi_definitions
-   `department_id` - UUID, Nullable, Foreign Key to departments
-   `period_start` - Date
-   `period_end` - Date
-   `target_value` - Decimal(15,4)
-   `min_threshold` - Decimal(15,4), Nullable
-   `max_threshold` - Decimal(15,4), Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### KPI Values Table (`kpi_values`)

-   `id` - UUID, Primary Key
-   `kpi_id` - UUID, Foreign Key to kpi_definitions
-   `department_id` - UUID, Nullable, Foreign Key to departments
-   `date` - Date
-   `actual_value` - Decimal(15,4)
-   `target_value` - Decimal(15,4)
-   `variance` - Decimal(15,4)
-   `variance_percentage` - Decimal(5,2)
-   `status` - Enum ['above_target', 'on_target', 'below_target', 'critical']
-   `notes` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Data Exports Table (`data_exports`)

-   `id` - UUID, Primary Key
-   `name` - String(100)
-   `description` - Text, Nullable
-   `type` - Enum ['full', 'incremental']
-   `format` - Enum ['csv', 'json', 'xml', 'excel']
-   `compression` - Enum ['none', 'zip', 'gzip'], Default 'none'
-   `destination` - Enum ['email', 'ftp', 'sftp', 's3']
-   `destination_config` - JSON # Connection details for destination
-   `schedule` - JSON, Nullable # Cron expression or schedule config
-   `last_run` - Timestamp, Nullable
-   `next_run` - Timestamp, Nullable
-   `is_active` - Boolean, Default true
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Export Logs Table (`export_logs`)

-   `id` - UUID, Primary Key
-   `export_id` - UUID, Foreign Key to data_exports
-   `start_time` - Timestamp
-   `end_time` - Timestamp, Nullable
-   `status` - Enum ['running', 'completed', 'failed']
-   `record_count` - Integer, Nullable
-   `file_size` - Integer, Nullable # in bytes
-   `file_path` - String(500), Nullable
-   `error_message` - Text, Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

### Analytics Events Table (`analytics_events`)

-   `id` - UUID, Primary Key
-   `event_type` - String(50)
-   `event_source` - String(50)
-   `user_id` - UUID, Nullable, Foreign Key to users
-   `session_id` - String(100), Nullable
-   `event_data` - JSON
-   `ip_address` - String(45), Nullable
-   `user_agent` - String(255), Nullable
-   `created_at` - Timestamp

### Analytics Aggregates Table (`analytics_aggregates`)

-   `id` - UUID, Primary Key
-   `metric_name` - String(50)
-   `dimension` - String(50)
-   `dimension_value` - String(100)
-   `date` - Date
-   `hour` - Integer, Nullable # 0-23
-   `count` - Integer
-   `sum` - Decimal(15,4), Nullable
-   `avg` - Decimal(15,4), Nullable
-   `min` - Decimal(15,4), Nullable
-   `max` - Decimal(15,4), Nullable
-   `created_at` - Timestamp
-   `updated_at` - Timestamp

### Report Access Logs Table (`report_access_logs`)

-   `id` - UUID, Primary Key
-   `report_id` - UUID, Foreign Key to report_definitions
-   `user_id` - UUID, Foreign Key to users
-   `access_type` - Enum ['view', 'export', 'schedule', 'edit']
-   `ip_address` - String(45)
-   `user_agent` - String(255)
-   `created_at` - Timestamp

### Analytics Audits Table (`analytics_audits`)

-   `id` - UUID, Primary Key
-   `auditable_type` - String(100) # reports, dashboards, kpis, exports, etc.
-   `auditable_id` - UUID
-   `event` - Enum ['created', 'updated', 'deleted', 'executed', 'exported']
-   `old_values` - JSON, Nullable
-   `new_values` - JSON, Nullable
-   `user_id` - UUID, Foreign Key to users
-   `created_at` - Timestamp
