<?php
/**
 * Created by PhpStorm.
 * User: MIOJI
 * Date: 2017/3/29
 * Time: 下午12:33
 */

namespace Songyichao\Kscnd\Core\Handler;


class GetBucketLoggingHandler implements Handler
{
    public function handle(\ResponseCore $response)
    {
        $logging = [];
        $xml = new \SimpleXMLElement($response->body);
        $loggingXml = $xml->LoggingEnabled;
        if ($loggingXml && $loggingXml !== NULL) {
            foreach ($loggingXml->children() as $key => $value) {
                $logging["Enable"] = TRUE;
                $logging[$key] = $value->__toString();
            }
        } else {
            $logging["Enable"] = FALSE;
        }

        return $logging;
    }
}