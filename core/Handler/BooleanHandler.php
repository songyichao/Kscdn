<?php
/**
 * Created by PhpStorm.
 * User: MIOJI
 * Date: 2017/3/29
 * Time: 下午2:16
 */

namespace Songyichao\Kscnd\Core\Handler;


class BooleanHandler implements Handler
{
    public function handle(\ResponseCore $response)
    {
        if ($response->isOk()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}