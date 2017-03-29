<?php

namespace Songyichao\Kscnd\Encryption\Handler;

interface EncryptionHandler
{
    public function putObjectByContentSecurely($args = []);

    public function putObjectByFileSecurely($args = []);

    public function getObjectSecurely($args = []);

    public function initMultipartUploadSecurely($args = []);

    public function uploadPartSecurely($args = []);

    public function abortMultipartUploadSecurely($args = []);

    public function completeMultipartUploadSecurely($args = []);
}