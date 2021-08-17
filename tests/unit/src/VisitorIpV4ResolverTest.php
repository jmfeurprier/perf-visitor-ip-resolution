<?php

namespace perf\VisitorIpResolution;

use perf\VisitorIpResolution\Exception\VisitorIpResolutionException;
use PHPUnit\Framework\TestCase;

class VisitorIpV4ResolverTest extends TestCase
{
    private VisitorIpV4Resolver $resolver;

    protected function setUp(): void
    {
        $this->resolver = new VisitorIpV4Resolver();
    }

    public function testResolveWithUnresolvableIpWillThrowException()
    {
        $serverValues = [];

        $this->expectException(VisitorIpResolutionException::class);
        $this->expectExceptionMessage('Failed to resolve visitor IP address.');

        $this->resolver->resolve($serverValues);
    }

    public function testResolveWithInvalidIpFormatWillThrowException()
    {
        $serverValues = [
            'REMOTE_ADDR' => '1.2.3.foo',
        ];

        $this->expectException(VisitorIpResolutionException::class);
        $this->expectExceptionMessage('Invalid IP format.');

        $this->resolver->resolve($serverValues);
    }

    public function testResolveWithValidIp()
    {
        $ip = '1.2.3.4';

        $serverValues = [
            'REMOTE_ADDR' => $ip,
        ];

        $result = $this->resolver->resolve($serverValues);

        $this->assertSame($ip, $result);
    }
}
