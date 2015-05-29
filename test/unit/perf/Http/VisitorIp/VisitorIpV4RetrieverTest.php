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
}
