<?php
/**
 * Created by PhpStorm.
 * User: MIOJI
 * Date: 2017/3/29
 * Time: 下午2:32
 */

namespace Songyichao\Kscnd\Core\Signer;


use Songyichao\Kscnd\Core\Headers;
use Songyichao\Kscnd\Core\Ks3Request;

class ContentLengthSigner implements Signer
{
    public function sign(Ks3Request $request, $args = [])
    {
        $args = $args["args"];
        $contentlength = "";
        if (isset($args["ObjectMeta"][Headers::$ContentLength])) {
            $contentlength = $args["ObjectMeta"][Headers::$ContentLength];
        }
        if (empty($contentlength)) {
            $body = $request->body;
            if (!empty($body)) {
                $contentlength = strlen($body);
            }
        }
        if (!empty($contentlength))
            $request->addHeader(Headers::$ContentLength, $contentlength);
    }
}