### ULoginLaravel

---

#### Installation:

1. Run: `composer require artarts36/ulogin-laravel`

2. Run: `php artisan vendor:publish --tag=ulogin`

3.  In bootstrap/app.php add:
```php
$app->bind(\ArtARTs36\ULoginLaravel\Contracts\User::class, \App\User::class);
```

4. In config/app.php in "providers" add:
```
ArtARTs36\ULoginLaravel\Providers\ULoginAuthProvider::class
```

6. In \App\User:
    * add implements interface `\ArtARTs36\ULoginLaravel\Contracts\User`
    * add use trait `ArtARTs36\ULoginLaravel\Support\UserOnULogin`
    
    Example:
    ```php
    namespace App;
    
    use ArtARTs36\ULoginLaravel\Support\UserOnULogin;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    
    class User extends Authenticatable implements \ArtARTs36\ULoginLaravel\Contracts\User
    {
        use UserOnULogin;
    }
   ```

7. In \App\Http\Middleware\VerifyCsrfToken in $except add:
`'https://ulogin.ru/*'`

8. Run: `php artisan migrate`
