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
use Songyichao\Kscnd\Exceptions\Ks3ClientException;

class AdpSigner
{
    public function sign(Ks3Request $request, $args = [])
    {
        $args = $args["args"];
        if (isset($args["Adp"])) {
            $AdpConf = $args["Adp"];
            if (is_array($AdpConf)) {
                if (isset($AdpConf["NotifyURL"])) {
                    $NotifyURL = $AdpConf["NotifyURL"];
                } else {
                    throw new Ks3ClientException("adp should provide NotifyURL");
                }
                if (isset($AdpConf["Adps"])) {
                    $Adps = $AdpConf["Adps"];
                } else {
                    throw new Ks3ClientException("adp should provide Adps");
                }
                $AdpString = "";
                foreach ($Adps as $Adp) {
                    if (is_array($Adp)) {
                        if (!isset($Adp["Command"])) {
                            throw new Ks3ClientException("command is needed in adp");
                        }
                        $command = $Adp["Command"];
                        $bucket = NULL;
                        $key = NULL;
                        if (isset($Adp["Bucket"])) {
                            $bucket = $Adp["Bucket"];
                        }
                        if (isset($Adp["Key"])) {
                            $key = $Adp["Key"];
                        }
                        $AdpString .= $command;
                        if (!(empty($bucket) && empty($key))) {
                            if (empty($bucket)) {
                                $AdpString .= "|tag=saveas&object=" . base64_encode($key);
                            } elseif (empty($key)) {
                                $AdpString .= "|tag=saveas&bucket=" . $bucket;
                            } else {
                                $AdpString .= "|tag=saveas&bucket=" . $bucket . "&" . "object=" . base64_encode($key);
                            }
                        }
                        $AdpString .= ";";
                    }
                }
                if (!empty($AdpString) && !empty($NotifyURL)) {
                    $request->addHeader(Headers::$AsynchronousProcessingList, $AdpString);
                    $request->addHeader(Headers::$NotifyURL, $NotifyURL);
                }
            }
        }
    }
}