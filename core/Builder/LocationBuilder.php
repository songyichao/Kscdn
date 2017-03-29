<?php
/**
 * Created by PhpStorm.
 * User: MIOJI
 * Date: 2017/3/29
 * Time: 下午12:17
 */

namespace Songyichao\Kscnd\Core\Builder;


class LocationBuilder
{
    function build($args)
    {
        if (isset($args["Location"])) {
            $location = $args["Location"];
            $xml = new \SimpleXmlElement('<CreateBucketConfiguration xmlns="http://s3.amazonaws.com/doc/2006-03-01/"></CreateBucketConfiguration>');
            $xml->addChild("LocationConstraint", $args["Location"]);

            return $xml->asXml();
        }
    }
}