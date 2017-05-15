# ChatKun
Laravel package for make sample chat application with Ratchet WebSockets.

##Server Requirements
- PHP >= 5.6.4
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension


# Install and Setup

## 1. Make Authentication Page
Using artisan command to create authentication page.
```php
 php artisan make:auth
    
```

## 2. Make Vendor:Publish
Using artisan command to generate our resource such as view,controller,model and migration.
```php
 php artisan verdor:publish
    
```

## 3. Create database table with migration file.
Using artisan command to automaticaly create database tables from migration file.
```php
 php artisan migrate
    
```
## 4. Add Route 
Add our router for make chatting example page.
```php
#routes/web.php
 
Route::get('chatkun',  'nattaponra\chatkun\ChatKunController@index');
    
    
```

## 5. Run Web Socket
Open command line to run socket commanication for support chatting.
```php
php artisan chatkun:serve
```


