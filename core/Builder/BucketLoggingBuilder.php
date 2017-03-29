<?php
/**
 * Created by PhpStorm.
 * User: MIOJI
 * Date: 2017/3/29
 * Time: 下午12:18
 */

namespace Songyichao\Kscnd\Core\Builder;


use Songyichao\Kscnd\Exceptions\Ks3ClientException;

class BucketLoggingBuilder
{
    function build($args)
    {
        if (isset($args["BucketLogging"])) {
            $logging = $args["BucketLogging"];
            $xml = new \SimpleXmlElement('<BucketLoggingStatus xmlns="http://s3.amazonaws.com/doc/2006-03-01/" />');
            if (is_array($logging)) {

                if (!isset($logging["Enable"]))
                    throw new Ks3ClientException("bucket logging must provide Enable argument");

                if ($logging["Enable"]) {
                    if (!isset($logging["TargetBucket"]))
                        throw new Ks3ClientException("bucket logging must provide TargetBucket argument");
                    $loggingConfig = $xml->addChild("LoggingEnabled");
                    foreach ($logging as $key => $value) {
                        if (in_array($key, Consts::$BucketLoggingElements)) {
                            $loggingConfig->addChild($key, $value);
                        }
                    }
                }
            }

            return $xml->asXml();
        }
    }
}