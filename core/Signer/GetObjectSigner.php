<?php
/**
 * Created by PhpStorm.
 * User: MIOJI
 * Date: 2017/3/29
 * Time: 下午2:41
 */

namespace Songyichao\Kscnd\Core\Signer;


use Songyichao\Kscnd\Core\Ks3Request;
use Songyichao\Kscnd\Core\Utils;

class GetObjectSigner
{
    public function sign(Ks3Request $request, $args = [])
    {
        $args = $args["args"];
        if (isset($args["WriteTo"])) {
            $WriteTo = $args["WriteTo"];
            if (is_resource($WriteTo)) {
                $request->write_stream = $WriteTo;
            } else {
                //如果之前用户已经转化为GBK则不转换
                if (Utils::chk_chinese($WriteTo) && !Utils::check_char($WriteTo)) {
                    $WriteTo = iconv('utf-8', 'gbk', $WriteTo);
                }
                $request->write_stream = fopen($WriteTo, "w");
            }
        }
    }
}
