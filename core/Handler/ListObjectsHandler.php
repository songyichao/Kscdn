<?php
/**
 * Created by PhpStorm.
 * User: MIOJI
 * Date: 2017/3/29
 * Time: 下午12:31
 */

namespace Songyichao\Kscnd\Core\Handler;


class ListObjectsHandler implements Handler
{
    public function handle(\ResponseCore $response)
    {
        $result = [];
        $xml = new \SimpleXMLElement($response->body);
        $result["Name"] = $xml->Name->__toString();
        $result["Prefix"] = $xml->Prefix->__toString();
        $result["Marker"] = $xml->Marker->__toString();
        $result["Delimiter"] = $xml->Delimiter->__toString();
        $result["MaxKeys"] = $xml->MaxKeys->__toString();
        $result["IsTruncated"] = $xml->IsTruncated->__toString();
        $result["NextMarker"] = $xml->NextMarker->__toString();
        $contents = [];
        foreach ($xml->Contents as $contentXml) {
            $content = [];
            foreach ($contentXml->children() as $key => $value) {
                $owner = [];
                if ($key === "Owner") {
                    foreach ($value->children() as $ownerkey => $ownervalue) {
                        $owner[$ownerkey] = $ownervalue->__toString();
                    }
                    $content["Owner"] = $owner;
                } else {
                    $content[$key] = $value->__toString();
                }
            }
            array_push($contents, $content);
        }
        $result["Contents"] = $contents;

        $commonprefix = [];
        foreach ($xml->CommonPrefixes as $commonprefixXml) {
            foreach ($commonprefixXml->children() as $key => $value) {
                array_push($commonprefix, $value->__toString());
            }
        }
        $result["CommonPrefixes"] = $commonprefix;

        return $result;
    }
}