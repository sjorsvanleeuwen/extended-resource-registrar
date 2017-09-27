## Laravel Extended Resource Registrar

This is a package to extend the resource registrar with Laravel 5.
It includes a ServiceProvider to register the new router.

## Installation

Require this package with composer. It is recommended to only require the package for development.

```shell
composer require sjorsvanleeuwen/laravel-extended-resource-registrar
```
Laravel 5.5 uses Package Auto-Discovery, so doesn't require you to manually add the ServiceProvider.

Make sure to change your app/Http/Kernel.php like so
```php
/**
 * Get the route dispatcher callback.
 * Do this to make the new Router work
 *
 * @return \Closure
 */
protected function dispatchToRouter()
{
    $this->router = $this->app['router'];

    foreach ($this->middlewareGroups as $key => $middleware)
    {
        $this->router->middlewareGroup($key, $middleware);
    }

    foreach ($this->routeMiddleware as $key => $middleware)
    {
        $this->router->aliasMiddleware($key, $middleware);
    }

    return parent::dispatchToRouter();
}
```

THe reason for this addition: The default router is already bound and passed on to the kernel before other serviceproviders are loaded, the kernel does not know about the new Router and can not load the routes registered because they are registered with the new router and the kernel bound in public/index.php has the default router bound.

### Laravel 5.5+:

If you don't use auto-discovery, add the ServiceProvider to the providers array in config/app.php

```php
Sjorsvanleeuwen\ExtendedResourceRegistrar\ServiceProvider::class,
```

### Lumen:

Not tested with Lumen

## Usage

You can now create a resourceful route with softDeletes

```php
Route::resource('foo', 'FooController')->withSoftDeletes();
```