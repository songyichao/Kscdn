<?php
/**
 * Created by PhpStorm.
 * User: MIOJI
 * Date: 2017/3/29
 * Time: 下午2:16
 */

namespace Songyichao\Kscnd\Core\Handler;


class AdpHandler implements Handler{
    public function handle(\ResponseCore $response){
        return $response->body;
    }
}