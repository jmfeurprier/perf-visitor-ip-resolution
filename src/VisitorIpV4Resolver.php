<?php

namespace perf\VisitorIpResolution;

use perf\VisitorIpResolution\Exception\VisitorIpResolutionException;

class VisitorIpV4Resolver implements VisitorIpResolverInterface
{
    private const SERVER_KEYS = [
        'REMOTE_ADDR',
        'HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED_FOR',
    ];

    public static function create(): VisitorIpV4Resolver
    {
        return new self();
    }

    /**
     * {@inheritDoc}
     */
    public function resolve(array $serverValues = null): string
    {
        $serverValues = $this->getServerValues($serverValues);

        foreach (self::SERVER_KEYS as $key) {
            if (array_key_exists($key, $serverValues)) {
                $ip = $serverValues[$key];

                if (false !== filter_var($ip, \FILTER_VALIDATE_IP, \FILTER_FLAG_IPV4)) {
                    return $ip;
                }

                throw new VisitorIpResolutionException('Invalid IP format.');
            }
        }

        throw new VisitorIpResolutionException('Failed to resolve visitor IP address.');
    }

    /**
     * @param null|array $serverValues Values from $_SERVER superglobal variable.
     *
     * @return array
     *
     * @throws VisitorIpResolutionException
     */
    private function getServerValues(?array $serverValues): array
    {
        if (null === $serverValues) {
            if (!isset($_SERVER)) {
                $message = 'Unable to retrieve visitor IP address: '
                    . 'superglobal variable $_SERVER is not set. '
                    . 'Calling retriever from command line?';

                throw new VisitorIpResolutionException($message);
            }

            $serverValues = $_SERVER;
        }

        return $serverValues;
    }
}
