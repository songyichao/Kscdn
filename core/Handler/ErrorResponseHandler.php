<?php

namespace Songyichao\Kscnd\Core\Handler;

use Songyichao\Kscnd\Exceptions\Ks3ServiceException;

/**
 * Created by PhpStorm.
 * User: MIOJI
 * Date: 2017/3/29
 * Time: 下午12:23
 */
class ErrorResponseHandler implements Handler
{
    /**
     * @param \ResponseCore $response
     * @return \ResponseCore
     */
    public function handle(\ResponseCore $response)
    {
        $code = $response->status;
        if ($code >= 400) {
            $exception = new Ks3ServiceException();
            $exception->statusCode = $code;
            if (!empty($response->body)) {
                $xml = new \SimpleXMLElement($response->body);
                $exception->requestId = $xml->RequestId->__toString();
                $exception->errorCode = $xml->Code->__toString();
                $exception->errorMessage = $xml->Message->__toString();
                $exception->resource = $xml->Resource->__toString();
            }
            throw $exception;
        } else {
            return $response;
        }
    }
}