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
php artisan optimize:clea