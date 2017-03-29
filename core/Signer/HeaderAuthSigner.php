<?php
/**
 * Created by PhpStorm.
 * User: MIOJI
 * Date: 2017/3/29
 * Time: 下午2:28
 */

namespace Songyichao\Kscnd\Core\Signer;


use Songyichao\Kscnd\Core\Headers;
use Songyichao\Kscnd\Core\Ks3Request;
use Songyichao\Kscnd\Exceptions\Ks3ClientException;

class HeaderAuthSigner implements Signer
{
    public function sign(Ks3Request $request, $args = [])
    {
        $log = "stringToSing->\r\n";
        $date = gmdate('D, d M Y H:i:s \G\M\T');
        $request->addHeader(Headers::$Date, $date);

        $ak = $args["accessKey"];
        $sk = $args["secretKey"];
        if (empty($ak)) {
            throw new Ks3ClientException("you should provide accessKey");
        }
        if (empty($sk)) {
            throw new Ks3ClientException("you should provide secretKey");
        }
        $authration = "KSS ";
        $signList = [
            $request->method,
            $request->getHeader(Headers::$ContentMd5),
            $request->getHeader(Headers::$ContentType),
            $date,
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

        $authration .= $ak . ":" . $signature;
        $request->addHeader(Headers::$Authorization, $authration);

        return $log;
    }
}