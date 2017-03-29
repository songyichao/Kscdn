<?php
/**
 * Created by PhpStorm.
 * User: MIOJI
 * Date: 2017/3/29
 * Time: 下午2:17
 */

namespace Songyichao\Kscnd\Core\Handler;

use Songyichao\Kscnd\Lib\ResponseCore;

class ExistsHandler implements Handler{
    public function handle(ResponseCore $response){
        $status = $response->status;
        if($status === 404){
            return FALSE;
        }else{
            return TRUE;
        }
    }
}