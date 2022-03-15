<?php

namespace Package\Component\Tests\Unit;

use Tests\TestCase;

class ResponseMacroTest extends TestCase
{
    public function testResponseMacro()
    {
        $response = response()->success();
        $this->assertEquals(200, $response->getStatusCode());

        $x = json_decode($response->getContent(), true);
        $this->assertEquals(0, $x['error_code']);
        $this->assertEquals('success', $x['message']);
        $this->assertEquals([], $x['data']);

        $response = response()->success(['a'], 'b', 1);
        $x = json_decode($response->getContent(), true);
        $this->assertEquals(1, $x['error_code']);
        $this->assertEquals('b', $x['message']);
        $this->assertEquals(['a'], $x['data']);
    }

    public function testResponseMacroError()
    {
        $response = response()->error('error');
        $this->assertEquals(400, $response->getStatusCode());

        $x = json_decode($response->getContent(), true);
        $this->assertEquals(1000, $x['error_code']);
        $this->assertEquals('error', $x['message']);
        $this->assertArrayNotHasKey('data', $x);

        $response = response()->error('error2', 2, ['a']);
        $x = json_decode($response->getContent(), true);
        $this->assertEquals(2, $x['error_code']);
        $this->assertEquals('error2', $x['message']);
        $this->assertEquals(['a'], $x['data']);
    }
}
