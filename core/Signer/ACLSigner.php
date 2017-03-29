<?php
/**
 * Created by PhpStorm.
 * User: MIOJI
 * Date: 2017/3/29
 * Time: 下午2:31
 */

namespace Songyichao\Kscnd\Core\Signer;


use Songyichao\Kscnd\Config\Consts;
use Songyichao\Kscnd\Core\Headers;
use Songyichao\Kscnd\Core\Ks3Request;
use Songyichao\Kscnd\Exceptions\Ks3ClientException;

class ACLSigner implements Signer
{
    public function sign(Ks3Request $request, $args = [])
    {
        $args = $args["args"];
        if (isset($args["ACL"])) {
            $acl = $args["ACL"];
            if (!in_array($acl, Consts::$Acl)) {
                throw new Ks3ClientException("unsupport acl :" . $acl);
            } else {
                $request->addHeader(Headers::$Acl, $acl);
            }
        }
        if (isset($args["ACP"])) {

        }
    }
}
