<?php
/**
 * Created by PhpStorm.
 * User: MIOJI
 * Date: 2017/3/29
 * Time: 下午2:43
 */

namespace Songyichao\Kscnd\Core\Signer;


use Songyichao\Kscnd\Config\Consts;
use Songyichao\Kscnd\Core\Headers;
use Songyichao\Kscnd\Core\Ks3Request;
use Songyichao\Kscnd\Core\Utils;

class SSECSigner
{
    public function sign(Ks3Request $request, $args = [])
    {
        $args = $args["args"];
        if (isset($args["SSEC"])) {
            if (isset($args["SSEC"]["Algm"]))
                $algm = $args["SSEC"]["Algm"];
            if (isset($args["SSEC"]["Key"]))
                $key = $args["SSEC"]["Key"];
            if (isset($args["SSEC"]["KeyBase64"]))
                $keybase64 = $args["SSEC"]["KeyBase64"];
            if (isset($args["SSEC"]["KeyMD5"]))
                $md5 = $args["SSEC"]["KeyMD5"];
            if (!empty($key) || !empty($keybase64)) {
                if (empty($key))
                    $key = base64_decode($keybase64);
                if (empty($algm))
                    $algm = Consts::$SSEDefaultAlgm;
                if (empty($md5))
                    $md5 = Utils::hex_to_base64(md5($key));

                $request->addHeader(Headers::$SSECAlgm, $algm);
                $request->addHeader(Headers::$SSECKey, base64_encode($key));
                $request->addHeader(Headers::$SSECMD5, $md5);
            }
        }
    }
}