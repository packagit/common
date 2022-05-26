<?php

namespace Tests\Unit;

use Tests\TestCase;

class ResponseMacroTest extends TestCase
{
    public function testResponseMacro()
    {
        $response = response()->ok();
        $this->assertEquals(200, $response->getStatusCode());

        $x = json_decode($response->getContent(), true);
        $this->assertEquals(0, $x['error_code']);
        $this->assertEquals('success', $x['message']);

        $response = response()->ok('a', 1, ['b']);
        $x = json_decode($response->getContent(), true);
        $this->assertEquals(1, $x['error_code']);
        $this->assertEquals('a', $x['message']);
        $this->assertEquals(['b'], $x['data']);
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
