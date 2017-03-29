<?php
/**
 * Created by PhpStorm.
 * User: MIOJI
 * Date: 2017/3/29
 * Time: 下午2:37
 */

namespace Songyichao\Kscnd\Core\Signer;


use Songyichao\Kscnd\Config\Consts;
use Songyichao\Kscnd\Core\Ks3Request;

class MultipartObjectMetaSigner implements Signer
{
    public function sign(Ks3Request $request, $args = [])
    {
        $args = $args["args"];
        if (isset($args["ObjectMeta"])) {
            $ObjectMeta = $args["ObjectMeta"];
            if (is_array($ObjectMeta)) {
                foreach ($ObjectMeta as $key => $value) {
                    if (in_array($key, Consts::$MultipartObjectMeta) && !empty($value)) {
                        $request->addHeader($key, $value);
                    }
                }
            }
        }
    }
}
