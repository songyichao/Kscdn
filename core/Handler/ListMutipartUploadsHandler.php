<?php
/**
 * Created by PhpStorm.
 * User: MIOJI
 * Date: 2017/3/29
 * Time: 下午2:16
 */

namespace Songyichao\Kscnd\Core\Handler;


class ListMutipartUploadsHandler implements Handler
{
    public function handle(\ResponseCore $response)
    {
        $mutiUploads = [];
        $xml = new \SimpleXMLElement($response->body);

        $mutiUploads["Bucket"] = $xml->Bucket->__toString();
        $mutiUploads["KeyMarker"] = $xml->KeyMarker->__toString();
        $mutiUploads["UploadIdMarker"] = $xml->UploadIdMarker->__toString();
        $mutiUploads["NextKeyMarker"] = $xml->NextKeyMarker->__toString();
        $mutiUploads["NextUploadIdMarker"] = $xml->NextUploadIdMarker->__toString();
        $mutiUploads["MaxUploads"] = $xml->MaxUploads->__toString();
        $mutiUploads["IsTruncated"] = $xml->IsTruncated->__toString();


        $uploads = [];
        foreach ($xml->Upload as $uploadxml) {
            $upload = [];
            foreach ($uploadxml->children() as $key => $value) {
                if ($key === "Initiator") {
                    $initer = [];
                    foreach ($value->children() as $key1 => $value1) {
                        $initer[$key1] = $value1->__toString();
                    }
                    $upload["Initiator"] = $initer;
                } elseif ($key === "Owner") {
                    $owner = [];
                    foreach ($value->children() as $key1 => $value1) {
                        $owner[$key1] = $value1->__toString();
                    }
                    $upload["Owner"] = $owner;
                } else {
                    $upload[$key] = $value->__toString();
                }
            }
            array_push($uploads, $upload);
        }
        $mutiUploads["Uploads"] = $uploads;

        return $mutiUploads;
    }
}