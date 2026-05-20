<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Crypt;

abstract class Controller
{
    protected function decryptRouteKey(string $encryptedId): int
    {
        try {
            return (int) Crypt::decryptString($encryptedId);
        } catch (DecryptException) {
            throw (new ModelNotFoundException())->setModel(Model::class);
        }
    }

    protected function findByEncryptedId(string $modelClass, string $encryptedId): Model
    {
        return $modelClass::query()->findOrFail($this->decryptRouteKey($encryptedId));
    }
}
