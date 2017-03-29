<?php
/**
 * Created by PhpStorm.
 * User: MIOJI
 * Date: 2017/3/29
 * Time: 下午2:15
 */

namespace Songyichao\Kscnd\Core\Handler;


class UploadHandler implements Handler
{
    public function handle(\ResponseCore $response)
    {
        $Headers = [];
        foreach ($response->header as $key => $value) {
            if (isset(Consts::$UploadHandler[strtolower($key)]) && !empty($value)) {
                $Headers[Consts::$UploadHandler[strtolower($key)]] = $value;
            }
        }

        return $Headers;
    }
}