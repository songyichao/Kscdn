<?php
/**
 * Created by PhpStorm.
 * User: MIOJI
 * Date: 2017/3/29
 * Time: 下午2:40
 */

namespace Songyichao\Kscnd\Core\Signer;


use Songyichao\Kscnd\Core\Headers;
use Songyichao\Kscnd\Core\Ks3Request;

class RangeSigner
{
    public function sign(Ks3Request $request, $args = [])
    {
        $args = $args["args"];
        if (isset($args["Range"])) {
            $Range = $args["Range"];
            if (is_array($Range)) {
                $start = $Range["start"];
                $end = $Range["end"];
                $range = "bytes=" . $start . "-" . $end;
                $request->addHeader(Headers::$Range, $range);
            } else
                $request->addHeader(Headers::$Range, $Range);
        }
    }
}