<?php
/**
 * Created by PhpStorm.
 * User: MIOJI
 * Date: 2017/3/29
 * Time: 下午2:44
 */

namespace Songyichao\Kscnd\Core\Signer;


use Songyichao\Kscnd\Core\Ks3Request;

class AllHeaderSigner
{
    public function sign(Ks3Request $request, $args = [])
    {
        $args = $args["args"];
        $headers = isset($args["Headers"]) ? $args["Headers"] : "";
        if (!empty($headers) && is_array($headers)) {
            foreach ($headers as $key => $value) {
                $request->addHeader($key, $value);
            }
        }
    }
}
