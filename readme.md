To get this baby to work please fix your app/Http/Kernel.php by adding the following:
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
If you want to know why: The default router is already bound and passed on to the kernel before other serviceproviders are loaded, therefore the kernel does not know about our new Router and can not load the routes registered because they are registered with the new router and the kernel is using the old router