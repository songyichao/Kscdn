<?php
/**
 * Created by PhpStorm.
 * User: MIOJI
 * Date: 2017/3/29
 * Time: 下午2:13
 */

namespace Songyichao\Kscnd\Core\Handler;

use Songyichao\Kscnd\Lib\ResponseCore;


class getObjectHandler implements Handler
{
    public function handle(ResponseCore $response)
    {
        $ObjectMeta = [];
        $UserMeta = [];
        foreach ($response->header as $key => $value) {
            if (substr(strtolower($key), 0, 10) === Consts::$UserMetaPrefix) {
                $UserMeta[$key] = $value;
            } else if (isset(Consts::$ResponseObjectMeta[strtolower($key)])) {
                $ObjectMeta[Consts::$ResponseObjectMeta[strtolower($key)]] = $value;
            }
        }
        $Meta = [
            "ObjectMeta" => $ObjectMeta,
            "UserMeta" => $UserMeta,
        ];
        $ks3Object = [
            "Content" => $response->body,
            "Meta" => $Meta,
        ];

        return $ks3Object;
    }
}