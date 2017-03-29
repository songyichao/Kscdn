<?php
/**
 * Created by PhpStorm.
 * User: MIOJI
 * Date: 2017/3/29
 * Time: 下午2:38
 */

namespace Songyichao\Kscnd\Core\Signer;


use Songyichao\Kscnd\Core\Headers;
use Songyichao\Kscnd\Core\Ks3Request;
use Songyichao\Kscnd\Core\Utils;
use Songyichao\Kscnd\Exceptions\Ks3ClientException;

class CopySourceSigner implements Signer
{
    public function sign(Ks3Request $request, $args = [])
    {
        $args = $args["args"];
        if (isset($args["CopySource"])) {
            $CopySource = $args["CopySource"];
            if (is_array($CopySource)) {
                if (!isset($CopySource["Bucket"]))
                    throw new Ks3ClientException("you should provide copy source bucket");
                if (!isset($CopySource["Key"]))
                    throw new Ks3ClientException("you should provide copy source key");
                $bucket = $CopySource["Bucket"];
                $key = Utils::encodeUrl($CopySource["Key"]);
                $request->addHeader(Headers::$CopySource, "/" . $bucket . "/" . $key);
            }
        }
    }
}