<?php

namespace App\Http\Middleware; // Perhatikan huruf besar

use Illuminate\Http\Middleware\TrustProxies as Middleware;

class TrustProxies extends Middleware
{
    protected $proxies;

    protected $headers = 0b111111; // Setara dengan HEADER_X_FORWARDED_ALL
}
