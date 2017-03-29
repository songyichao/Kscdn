<?php
/**
 * Created by PhpStorm.
 * User: MIOJI
 * Date: 2017/3/29
 * Time: 下午12:17
 */

namespace Songyichao\Kscnd\Core\Builder;


class CORSBuilder
{
    function build($args)
    {
        if (isset($args["CORS"])) {
            $cors = $args["CORS"];
            $xml = new \SimpleXmlElement('<CORSConfiguration xmlns="http://s3.amazonaws.com/doc/2006-03-01/"></CORSConfiguration>');
            if (is_array($cors)) {
                foreach ($cors as $key => $rule) {
                    $ruleXml = $xml->addChild("CORSRule");
                    if (is_array($rule)) {
                        foreach ($rule as $key => $value) {
                            if (in_array($key, Consts::$CORSElements)) {
                                if (is_array($value)) {
                                    foreach ($value as $ele) {
                                        $ruleXml->addChild($key, $ele);
                                    }
                                } else {
                                    $ruleXml->addChild($key, $value);
                                }

                            }
                        }
                    }
                }
            }

            return $xml->asXml();
        }
    }
}