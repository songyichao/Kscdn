<?php
/**
 * Created by PhpStorm.
 * User: MIOJI
 * Date: 2017/3/29
 * Time: 下午2:15
 */

namespace Songyichao\Kscnd\Core\Handler;

use Songyichao\Kscnd\Lib\ResponseCore;

class GetAclHandler implements Handler
{
    public function handle(ResponseCore $response)
    {
        $hasread = FALSE;
        $haswrite = FALSE;
        $xml = new \SimpleXMLElement($response->body);
        $acl = $xml->AccessControlList;
        foreach ($acl->children() as $grant) {
            $permission = $grant->Permission->__toString();
            $hasURI = FALSE;
            $grantee = $grant->Grantee;
            foreach ($grantee->children() as $key => $value) {
                if ($key === "URI" && $value->__toString() === Consts::$Grantee_Group_All) {
                    $hasURI = TRUE;
                }
            }
            if ($hasURI) {
                if ($permission === Consts::$Permission_Read) {
                    $hasread = TRUE;
                } elseif ($permission === Consts::$Permission_Write) {
                    $haswrite = TRUE;
                }
            }
        }
        if ($hasread && $haswrite) {
            return "public-read-write";
        } else {
            if ($hasread)
                return "public-read";
            else
                return "private";
        }
    }
}