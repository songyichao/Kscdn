<?php
/**
 * Created by PhpStorm.
 * User: MIOJI
 * Date: 2017/3/29
 * Time: 下午2:52
 */

namespace Songyichao\Kscnd\Encryption\CallBack;


use Songyichao\Kscnd\Encryption\EncryptionUtil;
use Songyichao\Kscnd\Lib\RequestCoreException;

class AESCBCStreamReadCallBack
{
    private $iv;
    private $cek;
    private $contentLength;
    private $buffer;
    private $hasread = 0;
    private $mutipartUpload = FALSE;
    private $isLastPart = FALSE;

    public function __set($property_name, $value)
    {
        $this->$property_name = $value;
    }

    public function __get($property_name)
    {
        if (isset($this->$property_name)) {
            return ($this->$property_name);
        } else {
            return (NULL);
        }
    }

    public function streaming_read_callback($curl_handle, $file_handle, $length, $read_stream, $seek_position)
    {
        // Once we've sent as much as we're supposed to send...
        if ($this->hasread >= $this->contentLength) {
            // Send EOF
            return '';
        }
        // If we're at the beginning of an upload and need to seek...
        if ($this->hasread == 0 && $seek_position > 0 && $seek_position !== ftell($read_stream)) {
            if (fseek($read_stream, $seek_position) !== 0) {
                throw new RequestCoreException('The stream does not support seeking and is either not at the requested position or the position is unknown.');
            }
        }


        $blocksize = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
        $needRead = min($this->contentLength - $this->hasread, $length);
        $read = fread($read_stream, $needRead);
        $this->hasread += strlen($read);
        $isLast = FALSE;
        if ($this->hasread >= $this->contentLength) {
            $isLast = TRUE;
        }
        $data = $this->buffer . $read;

        $dataLength = strlen($data);

        if (!$isLast) {
            $this->buffer = substr($data, $dataLength - $dataLength % $blocksize);
            $data = substr($data, 0, $dataLength - $dataLength % $blocksize);
        } else {
            //分块上传除最后一块外肯定是blocksize大小的倍数，所以不需要填充。
            if ($this->mutipartUpload) {
                if ($this->isLastPart) {
                    $this->buffer = NULL;
                    $data = EncryptionUtil::PKCS5Padding($data, $blocksize);
                } else {
                    //donothing
                }
            } else {
                $this->buffer = NULL;
                $data = EncryptionUtil::PKCS5Padding($data, $blocksize);
            }
        }
        $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
        mcrypt_generic_init($td, $this->cek, $this->iv);
        $encrypted = mcrypt_generic($td, $data);
        mcrypt_generic_deinit($td);
        //去除自动填充的16个字节//php的当恰好为16的倍数时竟然不填充？
        //$encrypted = substr($encrypted,0,strlen($encrypted)-$blocksize);
        //取最后一个block作为下一次的iv
        $this->iv = substr($encrypted, strlen($encrypted) - $blocksize);

        return $encrypted;
    }
}
