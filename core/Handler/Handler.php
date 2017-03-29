<?php
/**
 * Created by PhpStorm.
 * User: MIOJI
 * Date: 2017/3/29
 * Time: 下午12:34
 */

namespace Songyichao\Kscnd\Core\Handler;

use Songyichao\Kscnd\Lib\ResponseCore;


interface Handler
{
    /**
     * @param \ResponseCore $response
     * @return mixed
     */
    public function handle(ResponseCore $response);
}