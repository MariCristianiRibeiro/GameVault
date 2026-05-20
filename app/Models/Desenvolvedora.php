<?php

namespace App\Models;

use App\Models\Concerns\HasEncryptedRouteKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Desenvolvedora extends Model
{
    use HasEncryptedRouteKey;
    use HasFactory;

    protected $table = 'desenvolvedoras';

    protected $fillable = [
        'nome',
    ];

    public function jogos(): HasMany
    {
        return $this->hasMany(Jogo::class);
    }
}
