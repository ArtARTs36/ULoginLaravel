### ULoginLaravel

---

#### Installation:

1. Run: `composer require artarts36/ulogin-laravel` <br/>
2. Run: `php artisan vendor:publish --tag=ulogin` <br/>
3.  In bootstrap/app.php add:
```php
$app->bind(\ArtARTs36\ULoginLaravel\Contracts\User::class, \App\User::class);
```

4. In config/app.php in "providers" add:
```
ArtARTs36\ULoginLaravel\Providers\ULoginAuthProvider::class
```

6. In \App\User:
    * add implements interface '\ArtARTs36\ULoginLaravel\Contracts\User'
    * add use trait 'use ArtARTs36\ULoginLaravel\Support\UserOnULogin;'    
<br/>
7. In \App\Http\Middleware\VerifyCsrfToken in $except add:
"https://ulogin.ru/*"

8. Run: `php artisan migrate`
