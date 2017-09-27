<?php

namespace Sjorsvanleeuwen\ExtendedResourceRegistrar;

class PendingResourceRegistration extends \Illuminate\Routing\PendingResourceRegistration
{
    /**
     * Tell the resource to include softDelete routes.
     *
     * @return \Sjorsvanleeuwen\ExtendedResourceRegistrar\PendingResourceRegistration
     */
    public function withSoftDeletes()
    {
        $this->options['withSoftDeletes'] = true;

        return $this;
    }
}