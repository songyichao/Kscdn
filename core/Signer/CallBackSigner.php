<?php
/**
 * Created by PhpStorm.
 * User: MIOJI
 * Date: 2017/3/29
 * Time: 下午2:42
 */

namespace Songyichao\Kscnd\Core\Signer;


use Songyichao\Kscnd\Core\Headers;
use Songyichao\Kscnd\Core\Ks3Request;

class CallBackSigner
{
    public function sign(Ks3Request $request, $args = [])
    {
        $args = $args["args"];
        if (isset($args["CallBack"]) && is_array($args["CallBack"])) {
            $CallBackConf = $args["CallBack"];
            $url = NULL;
            $body = NULL;
            if (isset($CallBackConf["Url"])) {
                $url = $CallBackConf["Url"];
            }
            if (empty($url))
                throw new Ks3ClientException("Url is needed in CallBack");
            if (isset($CallBackConf["BodyMagicVariables"])) {
                if (is_array($CallBackConf["BodyMagicVariables"])) {
                    $magics = $CallBackConf["BodyMagicVariables"];
                    foreach ($magics as $key => $value) {
                        if (in_array($value, Consts::$CallBackMagics))
                            $body .= $key . "=\${" . $value . "}&";
                    }
                }
            }
            if (isset($CallBackConf["BodyVariables"])) {
                if (is_array($CallBackConf["BodyVariables"])) {
                    $variables = $CallBackConf["BodyVariables"];
                    foreach ($variables as $key => $value) {
                        $body .= $key . "=\${kss-" . $key . "}&";
                        $request->addHeader("kss-" . $key, $value);
                    }
                }
            }
            if (!empty($body)) {
                $body = substr($body, 0, strlen($body) - 1);
                $request->addHeader(Headers::$XKssCallbackBody, $body);
            }
            $request->addHeader(Headers::$XKssCallbackUrl, $url);
        }
    }
}