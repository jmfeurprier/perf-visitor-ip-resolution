<?php

namespace perf\Http\VisitorIp;

/**
 *
 */
class VisitorIpV4RetrieverTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     */
    protected function setUp()
    {
        $this->retriever = new VisitorIpV4Retriever();
    }

    /**
     *
     */
    public function testRetrieve()
    {
        $ip = '1.2.3.4';

        $serverValues = array(
            'REMOTE_ADDR' => $ip,
        );

        $result = $this->retriever->retrieve($serverValues);

        $this->assertSame($ip, $result);
    }

    /**
     *
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Unable to retrieve visitor IP v4 address.
     */
    public function testRetrieveWithUnresolvableIpWillThrowException()
    {
        $serverValues = array();

        $this->retriever->retrieve($serverValues);
    }
}
