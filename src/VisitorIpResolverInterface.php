<?php

namespace perf\VisitorIpResolution;

use perf\VisitorIpResolution\Exception\VisitorIpResolutionException;

interface VisitorIpResolverInterface
{
    /**
     * Attempts to retrieve current visitor IP address.
     *
     * @param null|array $serverValues Values from $_SERVER superglobal variable (optional).
     *
     * @return string
     *
     * @throws VisitorIpResolutionException
     */
    public function resolve(array $serverValues = null);
}
