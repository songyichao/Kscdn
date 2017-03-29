<?php
/**
 * Created by PhpStorm.
 * User: MIOJI
 * Date: 2017/3/29
 * Time: 下午2:14
 */

namespace Songyichao\Kscnd\Core\Handler;

use Songyichao\Kscnd\Lib\ResponseCore;

class ListPartsHandler implements Handler
{
    public function handle(ResponseCore $response)
    {
        $listParts = [];
        $xml = new \SimpleXMLElement($response->body);

        $listParts["Bucket"] = $xml->Bucket->__toString();
        $listParts["Key"] = $xml->Key->__toString();
        $listParts["UploadId"] = $xml->UploadId->__toString();
        $listParts["StorageClass"] = $xml->StorageClass->__toString();
        $listParts["PartNumberMarker"] = $xml->PartNumberMarker->__toString();
        $listParts["NextPartNumberMarker"] = $xml->NextPartNumberMarker->__toString();
        $listParts["MaxParts"] = $xml->MaxParts->__toString();
        $listParts["IsTruncated"] = $xml->IsTruncated->__toString();

        $initer = [];
        $owner = [];

        foreach ($xml->Initiator->children() as $key => $value) {
            $initer[$key] = $value->__toString();
        }
        foreach ($xml->Owner->children() as $key => $value) {
            $owner[$key] = $value->__toString();
        }
        $listParts["Owner"] = $owner;
        $listParts["Initiator"] = $initer;

        $parts = [];
        foreach ($xml->Part as $partxml) {
            $part = [];
            foreach ($partxml->children() as $key => $value) {
                $part[$key] = $value->__toString();
            }
            array_push($parts, $part);
        }
        $listParts["Parts"] = $parts;

        return $listParts;
    }
}