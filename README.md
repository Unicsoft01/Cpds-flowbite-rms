### installed Tailwind with a touch of flowbite libs

```php
npm install -D tailwindcss postcss autoprefixer flowbite
```

### Publishing the configuration file

```php
php artisan livewire:publish --config
```

### Multi guard auth

```php
php artisan make:model Admin -m -f
```

### seed Roles and permissions

```php
php artisan db:seed --class=RolesAndPermissionsSeeder
```

Recommended Assets to Cache

php artisan config:cache  
php artisan route:cache  
php artisan view:cache  
php artisan optimize

      php artisan config:clear
      php artisan route:clear
      php artisan view:clear
      php artisan optimize:clear

fixed problem with

```php
SQLSTATE[HY000]: General error: 1615 Prepared statement needs to be re-prepared (Connection: mysql, SQL: DELETE FROM courses WHERE course_id = 13)
```

Solution

```php
'options'   => [
      \PDO::ATTR_EMULATE_PREPARES => true
]
```
