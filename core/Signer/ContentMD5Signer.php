<?php

namespace Songyichao\Kscnd\Core\Signer;


use Songyichao\Kscnd\Core\Headers;
use Songyichao\Kscnd\Core\Ks3Request;
use Songyichao\Kscnd\Core\Utils;

class ContentMD5Signer implements Signer
{
    public function sign(Ks3Request $request, $args = [])
    {
        $args = $args["args"];
        $contentmd5 = "";
        if (isset($args["ObjectMeta"][Headers::$ContentMd5])) {
            $contentmd5 = $args["ObjectMeta"][Headers::$ContentMd5];
        }
        if (empty($contentmd5)) {
            $body = $request->body;
            if (!empty($body)) {
                $length = $request->getHeader(Headers::$ContentLength);
                if (empty($length)) {
                    if (isset($args["ObjectMeta"][Headers::$ContentLength]))
                        $length = $args["ObjectMeta"][Headers::$ContentLength];
                }
                if (!empty($length)) {
                    $body = substr($body, 0, $length);
                }
                $contentmd5 = Utils::hex_to_base64(md5($body));
            }
        }
        if (!empty($contentmd5))
            $request->addHeader(Headers::$ContentMd5, $contentmd5);
    }
}
