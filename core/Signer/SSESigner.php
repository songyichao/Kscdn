<?php
/**
 * Created by PhpStorm.
 * User: MIOJI
 * Date: 2017/3/29
 * Time: 下午2:43
 */

namespace Songyichao\Kscnd\Core\Signer;


use Songyichao\Kscnd\Core\Headers;
use Songyichao\Kscnd\Core\Ks3Request;

class SSESigner
{
    public function sign(Ks3Request $request, $args = [])
    {
        $args = $args["args"];
        if (isset($args["SSE"])) {
            if (isset($args["SSE"]["Algm"]))
                $algm = $args["SSE"]["Algm"];
            if (isset($args["SSE"]["KMSId"]))
                $id = $args["SSE"]["KMSId"];
            if (!empty($algm)) {
                $request->addHeader(Headers::$SSEAlgm, $algm);
                if (!empty($id))
                    $request->addHeader(Headers::$SSEKMSId, $id);
            }
        }
    }
}