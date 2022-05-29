<?php

namespace Packagit\Common\Tests\Feature;

use Tests\TestCase;
use Packagit\Common\AppHelper;
use Illuminate\Support\Facades\Route;

class AppHelperTest extends TestCase
{
    private $refererHeader = 'https://code0xff.com/wx111f724ce24c500/app/page-frame.html';
    private $fakeAppId = 'wx111f724ce24c500';

    protected function setUp(): void
    {
        parent::setUp();

        Route::get('/api/test_appid', function () {
            $appId = AppHelper::getAppId();
            $this->assertSame($this->fakeAppId, $appId);
        });
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_appid_with_header_referer()
    {
        $this
            ->withHeader('referer', $this->refererHeader)
            ->get('/api/test_appid');
    }

    public function test_appid_with_header_appid()
    {
        $this
            ->withHeader('appid', $this->fakeAppId)
            ->get('/api/test_appid');
    }

    public function test_appid_with_cookie()
    {
        $this
            ->withCookie('appid', $this->fakeAppId)
            ->get('/api/test_appid');
    }

    public function test_appid_with_query()
    {
        $this->get('/api/test_appid?appid=' . $this->fakeAppId);
    }
}
