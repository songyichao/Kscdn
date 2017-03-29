<?php
/**
 * Created by PhpStorm.
 * User: MIOJI
 * Date: 2017/3/29
 * Time: 下午2:44
 */

namespace Songyichao\Kscnd\Core\Signer;


use Songyichao\Kscnd\Config\Consts;
use Songyichao\Kscnd\Core\Headers;
use Songyichao\Kscnd\Core\Ks3Request;
use Songyichao\Kscnd\Core\Utils;

class SSECSourceSigner
{
    public function sign(Ks3Request $request, $args = [])
    {
        $args = $args["args"];
        if (isset($args["SSECSource"])) {
            if (isset($args["SSECSource"]["Algm"]))
                $algm = $args["SSECSource"]["Algm"];
            if (isset($args["SSECSource"]["Key"]))
                $key = $args["SSECSource"]["Key"];
            if (isset($args["SSECSource"]["KeyBase64"]))
                $keybase64 = $args["SSECSource"]["KeyBase64"];
            if (isset($args["SSECSource"]["KeyMD5"]))
                $md5 = $args["SSECSource"]["KeyMD5"];
            if (!empty($key) || !empty($keybase64)) {
                if (empty($key))
                    $key = base64_decode($keybase64);
                if (empty($algm))
                    $algm = Consts::$SSEDefaultAlgm;
                if (empty($md5))
                    $md5 = Utils::hex_to_base64(md5($key));

                $request->addHeader(Headers::$SSECSourceAlgm, $algm);
                $request->addHeader(Headers::$SSECSourceKey, base64_encode($key));
                $request->addHeader(Headers::$SSECSourceMD5, $md5);
            }
        }
    }
}
