<?php
/**
 * Created by PhpStorm.
 * User: MIOJI
 * Date: 2017/3/29
 * Time: 下午12:32
 */

namespace Songyichao\Kscnd\Core\Handler;

use Songyichao\Kscnd\Lib\ResponseCore;


class GetBucketCORSHandler implements Handler {
    public function handle(ResponseCore $response){
        $xml = new  \SimpleXMLElement($response->body);
        $cors = array();
        foreach ($xml->CORSRule as $rule) {
            $acors = array();
            foreach ($rule as $key => $value) {
                if($key === "MaxAgeSeconds")
                {
                    $acors[$key] = $value->__toString();
                }else{
                    if(!isset($acors[$key])){
                        $acors[$key] = array();
                    }
                    array_push($acors[$key],$value->__toString());
                }
            }
            array_push($cors,$acors);
        }
        return $cors;
    }
}