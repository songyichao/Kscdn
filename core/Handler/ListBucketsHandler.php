<?php
/**
 * Created by PhpStorm.
 * User: MIOJI
 * Date: 2017/3/29
 * Time: 下午12:31
 */

namespace Songyichao\Kscnd\Core\Handler;



class ListBucketsHandler implements Handler {

    public function handle(\ResponseCore $response){
        $result = array();
        $xml = new \SimpleXMLElement($response->body);
        foreach ($xml->Buckets->Bucket as $bucketXml) {
            $bucket = array();
            foreach ($bucketXml->children() as $key => $value) {
                $bucket[$key]=$value->__toString();
            }
            array_push($result, $bucket);
        }
        return $result;
    }
}