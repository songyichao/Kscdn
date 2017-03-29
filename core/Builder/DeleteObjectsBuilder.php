<?php
/**
 * Created by PhpStorm.
 * User: MIOJI
 * Date: 2017/3/29
 * Time: 下午12:19
 */

namespace Songyichao\Kscnd\Core\Builder;


class DeleteObjectsBuilder
{
    function build($args)
    {
        if (isset($args["DeleteKeys"])) {
            $keys = $args["DeleteKeys"];
            $xml = new \SimpleXmlElement('<Delete></Delete>');
            if (is_array($keys)) {
                foreach ($keys as $key => $value) {
                    $object = $xml->addChild("Object");
                    $object->addChild("Key", $value);
                }
            }

            return $xml->asXml();
        }
    }
}