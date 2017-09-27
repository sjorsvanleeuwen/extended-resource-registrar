<?php

namespace Sjorsvanleeuwen\ExtendedResourceRegistrar;

class ResourceRegistrar extends \Illuminate\Routing\ResourceRegistrar
{
    /**
     * The router instance.
     *
     * @var \Sjorsvanleeuwen\ExtendedResourceRegistrar\Router
     */
    protected $router;

    /**
     * The verbs used in the resource URIs.
     *
     * @var array
     */
    protected static $verbs = [
        'create' => 'create',
        'edit' => 'edit',
        'destroy' => 'destroy',
        'trashed' => 'trashed',
        'restore' => 'restore'
    ];

    /**
     * The default actions for a resourceful controller.
     *
     * @var array
     */
    protected $resourceDefaults = ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'];

    /**
     * The actions for a resourceful controller with SoftDeletes.
     *
     * @var array
     */
    protected $resourceSoftDeletes = ['index', 'trashed', 'create', 'store', 'show', 'edit', 'update', 'destroy', 'restore'];

    /**
     * Get the applicable resource methods.
     *
     * @param  array  $defaults
     * @param  array  $options
     * @return array
     */
    protected function getResourceMethods($defaults, $options)
    {
        if(isset($options['withSoftDeletes']) && $options['withSoftDeletes'] == true)
        {
            $defaults = $this->resourceSoftDeletes;
            unset($options['withSoftDeletes']);
        }
        return parent::getResourceMethods($defaults, $options);
    }

    /**
     * Add the trashed method for a resourceful route.
     *
     * @param  string  $name
     * @param  string  $base
     * @param  string  $controller
     * @param  array   $options
     * @return \Illuminate\Routing\Route
     */
    protected function addResourceTrashed($name, $base, $controller, $options)
    {
        $uri = $this->getResourceUri($name).'/'.static::$verbs['trashed'];

        $action = $this->getResourceAction($name, $controller, 'trashed', $options);

        return $this->router->get($uri, $action);
    }

    /**
     * Add the destroy method for a resourceful route.
     *
     * @param  string  $name
     * @param  string  $base
     * @param  string  $controller
     * @param  array   $options
     * @return \Illuminate\Routing\Route
     */
    protected function addResourceDestroy($name, $base, $controller, $options)
    {
        $uri = $this->getResourceUri($name).'/{'.$base.'}';

        $action = $this->getResourceAction($name, $controller, 'destroy', $options);

        if($this->router->getApiUsage())
        {
            $uri = $this->getResourceUri($name).'/{'.$base.'}'.static::$verbs['destroy'];

            return $this->router->get($uri, $action);
        }

        return $this->router->delete($uri, $action);
    }

    /**
     * Add the restore method for a resourceful route.
     *
     * @param  string  $name
     * @param  string  $base
     * @param  string  $controller
     * @param  array   $options
     * @return \Illuminate\Routing\Route
     */
    protected function addResourceRestore($name, $base, $controller, $options)
    {
        $uri = $this->getResourceUri($name).'/{'.$base.'}'.static::$verbs['restore'];

        $action = $this->getResourceAction($name, $controller, 'restore', $options);

        if($this->router->getApiUsage())
        {
            return $this->router->get($uri, $action);
        }

        return $this->router->put($uri, $action);
    }
}