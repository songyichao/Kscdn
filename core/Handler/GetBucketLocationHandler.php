<?php
/**
 * Created by PhpStorm.
 * User: MIOJI
 * Date: 2017/3/29
 * Time: 下午12:32
 */

namespace Songyichao\Kscnd\Core\Handler;

use Songyichao\Kscnd\Lib\ResponseCore;


class GetBucketLocationHandler implements Handler
{
    /**
     * @param \ResponseCore $response
     * @return string
     */
    public function handle(ResponseCore $response)
    {
        $xml = new \SimpleXMLElement($response->body);
        $location = $xml->__toString();

        return $location;
    }
}