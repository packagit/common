<?php

namespace Packagit\Common;

class AppHelper
{
    /**
     * 通过 appid 区分不同的小程序，不同客户端(微信内H5, 浏览器H5, APP等).
     *
     * @return int
     */
    public static function getAppId()
    {
        $appId = '';
        $headers = [];
        if (request()->headers) {
            $headers = request()->headers->all();
        }

        if (isset($headers['referer'])) {
            $refererArray = explode('/', $headers['referer'][0]);

            // Referer like this:
            // https://app.example.com/wx111f724ce24c500/app/page-frame.html
            // https://servicewechat.com/wx111f724ce24c500/devtools/page-frame.html

            if (count($refererArray) === 6 && $refererArray[5] === 'page-frame.html') {
                $appId = $refererArray[3];
            }
        }

        // header 读取 appid
        if (!$appId) {
            $appId = $headers['appid'][0] ?? '';
        }

        // cookie 读取 appid
        if (!$appId) {
            $appId = (string)optional(request())->cookie('appid');
        }

        // request url 读取 appid
        if (!$appId) {
            $appId = (string)request()->get('appid');
        }

        return $appId;
    }
}
