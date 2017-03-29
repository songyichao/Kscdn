<?php
/**
 * Created by PhpStorm.
 * User: MIOJI
 * Date: 2017/3/29
 * Time: 下午2:38
 */

namespace Songyichao\Kscnd\Core\Signer;

use Songyichao\Kscnd\Config\Consts;
use Songyichao\Kscnd\Core\Ks3Request;

class UserMetaSigner implements Signer
{
    public function sign(Ks3Request $request, $args = [])
    {
        $args = $args["args"];
        if (isset($args["UserMeta"])) {
            $UserMeta = $args["UserMeta"];
            if (is_array($UserMeta)) {
                foreach ($UserMeta as $key => $value) {
                    if (substr(strtolower($key), 0, 10) === Consts::$UserMetaPrefix) {
                        $request->addHeader($key, $value);
                    }
                }
            }
        }
    }
}
