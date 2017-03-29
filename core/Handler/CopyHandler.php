<?php
/**
 * Created by PhpStorm.
 * User: MIOJI
 * Date: 2017/3/29
 * Time: 下午2:13
 */

namespace Songyichao\Kscnd\Core\Handler;


class CopyHandler implements Handler
{
    public function handle(\ResponseCore $response)
    {
        $headers = [];

        foreach ($response->header as $key => $value) {
            if (isset(Consts::$SSEHandler[strtolower($key)]) && !empty($value)) {
                $headers[Consts::$SSEHandler[strtolower($key)]] = $value;
            }
        }

        return $headers;
    }
}