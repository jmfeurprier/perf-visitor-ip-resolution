<?php

namespace perf\Http\VisitorIp;

/**
 *
 *
 */
class VisitorIpV4Retriever implements VisitorIpRetriever
{

    /**
     * Attempts to retrieve current visitor IP v4 address.
     *
     * @param null|array $serverValues Values from $_SERVER superglobal variable (optional).
     * @return string
     * @throws \RuntimeException
     */
    public function retrieve(array $serverValues = null)
    {
        static $keys = array(
            'REMOTE_ADDR',
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
        );

        $serverValues = $this->getServerValues($serverValues);

        foreach ($keys as $key) {
            if (array_key_exists($key, $serverValues)) {
                $ip = $serverValues[$key];

                if (false !== filter_var($ip, \FILTER_VALIDATE_IP, \FILTER_FLAG_IPV4)) {
                    return $ip;
                }

                throw new \RuntimeException('Invalid IP v4 format.');
            }
        }

        throw new \RuntimeException('Unable to retrieve visitor IP v4 address.');
    }

    /**
     *
     *
     * @param null|array $serverValues Values from $_SERVER superglobal variable.
     * @return array
     * @throws \RuntimeException
     */
    private function getServerValues(array $serverValues = null)
    {
        if (is_null($serverValues)) {
            if (!isset($_SERVER)) {
                $message = 'Unable to retrieve visitor IP address: '
                         . 'superglobal variable $_SERVER is not set. '
                         . 'Calling retriever from command line?';

                throw new \RuntimeException($message);
            }

            $serverValues = $_SERVER;
        }

        return $serverValues;
    }
}
