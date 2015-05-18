<?php

namespace perf\Http\VisitorIp;

/**
 *
 *
 */
interface VisitorIpRetriever
{

    /**
     * Attempts to retrieve current visitor IP address.
     *
     * @param null|array $serverValues Values from $_SERVER superglobal variable (optional).
     * @return string
     * @throws \RuntimeException
     */
    public function retrieve(array $serverValues = null);
}
