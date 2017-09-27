<?php

namespace Sjorsvanleeuwen\ExtendedResourceRegistrar;

class Router extends \Illuminate\Routing\Router
{
    /**
     * Flag to determine restfull API or plain html
     *
     * @var bool
     */
    protected $api = false;

    /**
     * Route an api resource to a controller.
     *
     * @param  string  $name
     * @param  string  $controller
     * @param  array  $options
     * @return \Illuminate\Routing\PendingResourceRegistration
     */
    public function apiResource($name, $controller, array $options = [])
    {
        $this->api = true;
        $defaults = ['index', 'show', 'store', 'update', 'destroy'];
        if(isset($options['withSoftDeletes']))
        {
            $defaults = $defaults + ['trashed', 'trash', 'restore'];
            unset($options['withSoftDeletes']);
        }
        return $this->resource($name, $controller, array_merge([
            'only' => $defaults,
        ], $options));
    }

    /**
     * Determine if using restfull API or plain html
     *
     * @return bool
     */
    public function getApiUsage()
    {
        return $this->api;
    }

    /**
     * Route a resource to a controller.
     *
     * @param  string  $name
     * @param  string  $controller
     * @param  array  $options
     * @return \Illuminate\Routing\PendingResourceRegistration
     */
    public function resource($name, $controller, array $options = [])
    {
        if ($this->container && $this->container->bound(ResourceRegistrar::class)) {
            $registrar = $this->container->make(ResourceRegistrar::class);
        } else {
            $registrar = new ResourceRegistrar($this);
        }

        return new PendingResourceRegistration(
            $registrar, $name, $controller, $options
        );
    }
}