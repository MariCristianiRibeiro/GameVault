<?php

namespace App\Models;

use App\Models\Concerns\HasEncryptedRouteKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plataforma extends Model
{
    use HasEncryptedRouteKey;
    use HasFactory;

    protected $table = 'plataformas';

    protected $fillable = [
        'nome',
    ];

    public function jogos(): HasMany
    {
        return $this->hasMany(Jogo::class);
    }
}
