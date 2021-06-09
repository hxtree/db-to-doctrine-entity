# DB To Doctrine Entity

A simple project to generate Doctrine entities from an existing database.

## Setup
Configure database connection information:
```sql
vim bootstrap.php
```

Next run Doctine bin file:
```sql
php vendor/bin/doctrine  orm:convert-mapping -f --from-database annotation Entity/
```

## Debugging Tips:
Doctrine may not support some table options used, such as ENUMs or bit. In which case it is important to add those table
to exclude filter in bootstrap.php.
```
// exclude any tables here
$conn->getConfiguration()->setFilterSchemaAssetsExpression('~^(?!TableName)~');
```

Find tables containing ENUM:

```sql
select col.table_schema as database_name, col.table_name, col.ordinal_position as column_id, col.column_name, 
       col.data_type, trim(leading 'enum' from col.column_type) as enum_values 
from information_schema.columns col 
    join information_schema.tables tab on tab.table_schema = col.table_schema 
                                              and tab.table_name = col.table_name 
                                              and tab.table_type = 'BASE TABLE' 
where col.data_type in ('enum') 
  and col.table_schema not in ('information_schema', 'sys', 'performance_schema', 'mysql') 
  and col.table_schema = 'INSERT DATABASE NAME' 
order by col.table_schema, col.table_name, col.ordinal_position;
```

Find Tables containing BIT type:
```sql
select col.table_schema as database_name, col.table_name, col.ordinal_position as column_id, col.column_name, 
       col.data_type, trim(leading 'bit' from col.column_type) as bit_values 
from information_schema.columns col 
    join information_schema.tables tab on tab.table_schema = col.table_schema 
                                              and tab.table_name = col.table_name 
                                              and tab.table_type = 'BASE TABLE' 
where col.data_type in ('bit') 
  and col.table_schema not in ('information_schema', 'sys', 'performance_schema', 'mysql') 
  and col.table_schema = 'INSERT DATABASE NAME' 
order by col.table_schema, col.table_name, col.ordinal_position;
```