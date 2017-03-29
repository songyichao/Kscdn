<?php
/**
 * Created by PhpStorm.
 * User: MIOJI
 * Date: 2017/3/29
 * Time: 下午2:30
 */

namespace Songyichao\Kscnd\Core\Signer;


use Songyichao\Kscnd\Core\Ks3Request;

class QueryAuthSigner implements Signer
{
    public function sign(Ks3Request $request, $args = [])
    {
        $log = "stringToSing->\r\n";
        $ak = $args["accessKey"];
        $sk = $args["secretKey"];
        $expires = $args["args"]["Options"]["Expires"];
        $expiresSencond = time() + $expires;

        $resource = AuthUtils::canonicalizedResource($request);
        $signList = [
            $request->method,
            $request->getHeader(Headers::$ContentMd5),
            $request->getHeader(Headers::$ContentType),
            $expiresSencond,
        ];
        $headers = AuthUtils::canonicalizedKssHeaders($request);
        $resource = AuthUtils::canonicalizedResource($request);
        if (!empty($headers)) {
            array_push($signList, $headers);
        }
        array_push($signList, $resource);

        $stringToSign = join("\n", $signList);
        $log .= $stringToSign;
        $signature = base64_encode(hash_hmac('sha1', $stringToSign, $sk, true));
        $request->addQueryParams("KSSAccessKeyId", $ak);
        $request->addQueryParams("Signature", $signature);
        $request->addQueryParams("Expires", $expiresSencond);

        return $log;
    }
}