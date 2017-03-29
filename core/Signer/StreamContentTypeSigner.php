<?php
/**
 * Created by PhpStorm.
 * User: MIOJI
 * Date: 2017/3/29
 * Time: 下午2:26
 */

namespace Songyichao\Kscnd\Core\Signer;

use Songyichao\Kscnd\Core\Headers;
use Songyichao\Kscnd\Core\Ks3Request;

class StreamContentTypeSigner implements Signer
{
    public function sign(Ks3Request $request, $args = [])
    {
        $contentType = $request->getHeader(Headers::$ContentType);
        if (empty($contentType)) {
            $request->addHeader(Headers::$ContentType, "application/ocet-stream");
        }
    }
}
