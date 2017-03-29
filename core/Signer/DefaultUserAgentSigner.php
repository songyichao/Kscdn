<?php
/**
 * Created by PhpStorm.
 * User: MIOJI
 * Date: 2017/3/29
 * Time: 下午2:24
 */

namespace Songyichao\Kscnd\Core\Signer;


use Songyichao\Kscnd\Config\Consts;
use Songyichao\Kscnd\Core\Headers;
use Songyichao\Kscnd\Core\Ks3Request;

class DefaultUserAgentSigner implements Signer
{
    public function sign(Ks3Request $request, $args = [])
    {
        $request->addHeader(Headers::$UserAgent, Consts::$UserAgent);
    }
}
