<?php

namespace Songyichao\Kscnd\Core\Signer;

use Songyichao\Kscnd\Core\Ks3Request;

interface Signer
{
    public function sign(Ks3Request $request, $args = []);
}