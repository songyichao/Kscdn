<?php
/**
 * Created by PhpStorm.
 * User: MIOJI
 * Date: 2017/3/29
 * Time: 下午2:29
 */

namespace Songyichao\Kscnd\Core\Signer;


use Songyichao\Kscnd\Config\Consts;
use Songyichao\Kscnd\Core\Ks3Request;
use Songyichao\Kscnd\Core\Utils;

class AuthUtils
{
    public static function canonicalizedKssHeaders(Ks3Request $request)
    {
        $header = "";
        $headers = $request->headers;
        ksort($headers, SORT_STRING);
        foreach ($headers as $header_key => $header_value) {
            if (substr(strtolower($header_key), 0, 6) === Consts::$KS3HeaderPrefix) {
                $header .= "\n" . strtolower($header_key) . ':' . $header_value;
            }
        }
        $header = substr($header, 1);

        return $header;
    }

    public static function canonicalizedResource(Ks3Request $request)
    {
        $resource = "/";
        $bucket = $request->bucket;
        $key = $request->key;
        $subResource = $request->subResource;
        if (!empty($bucket)) {
            $resource .= $request->bucket . "/";
        }
        if (!empty($key)) {
            $resource .= Utils::encodeUrl($request->key);
        }

        $encodeParams = "";
        $querys = $request->queryParams;
        if (!empty($subResource)) {
            $querys[$subResource] = NULL;
        }
        ksort($querys, SORT_STRING);
        foreach ($querys as $key => $value) {
            if (in_array($key, Consts::$SubResource) || in_array($key, Consts::$QueryParam)) {
                if (empty($value)) {
                    $encodeParams .= "&" . $key;
                } else {
                    $encodeParams .= "&" . $key . "=" . $value;
                }
            }
        }
        $encodeParams = substr($encodeParams, 1);

        $resource = str_replace("//", "/%2F", $resource);

        if (!empty($encodeParams)) {
            $resource .= "?" . $encodeParams;
        }

        return $resource;
    }
}