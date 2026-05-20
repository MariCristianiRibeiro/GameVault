<?php

namespace App\Models\Concerns;

use Illuminate\Support\Facades\Crypt;

trait HasEncryptedRouteKey
{
    public function getRouteKeyAttribute(): string
    {
        return Crypt::encryptString((string) $this->getKey());
    }
}
