<?php
/**
 * Created by PhpStorm.
 * User: MIOJI
 * Date: 2017/3/29
 * Time: 下午2:14
 */

namespace Songyichao\Kscnd\Core\Handler;

use Songyichao\Kscnd\Lib\ResponseCore;

class InitMultipartUploadHandler implements Handler
{
    public function handle(ResponseCore $response)
    {
        $upload = [];
        $xml = new \SimpleXMLElement($response->body);
        foreach ($xml->children() as $key => $value) {
            $upload[$key] = $value->__toString();
        }

        foreach ($response->header as $key => $value) {
            if (isset(Consts::$SSEHandler[strtolower($key)]) && !empty($value)) {
                $upload[Consts::$SSEHandler[strtolower($key)]] = $value;
            }
        }

        return $upload;
    }
}