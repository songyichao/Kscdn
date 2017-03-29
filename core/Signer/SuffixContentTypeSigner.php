<?php
/**
 * Created by PhpStorm.
 * User: MIOJI
 * Date: 2017/3/29
 * Time: 下午2:27
 */

namespace Songyichao\Kscnd\Core\Signer;


use Songyichao\Kscnd\Core\Headers;
use Songyichao\Kscnd\Core\Ks3Request;
use Songyichao\Kscnd\Core\Utils;

class SuffixContentTypeSigner implements Signer
{
    public function sign(Ks3Request $request, $args = [])
    {
        $key = $request->key;
        $objArr = explode('/', $key);
        $basename = array_pop($objArr);
        $extension = explode('.', $basename);
        $extension = array_pop($extension);
        $content_type = Utils::get_mimetype(strtolower($extension));
        $request->addHeader(Headers::$ContentType, $content_type);
    }
}