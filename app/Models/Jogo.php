<?php

namespace App\Models;

use App\Models\Concerns\HasEncryptedRouteKey;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Jogo extends Model
{
    use HasEncryptedRouteKey;
    use HasFactory;

    public const STATUSS = [
        'Jogando',
        'Finalizado',
        'Backlog',
    ];

    protected $table = 'jogos';

    protected $fillable = [
        'titulo',
        'descricao',
        'horas_jogadas',
        'nota',
        'status',
        'data_lancamento',
        'plataforma_id',
        'genero_id',
        'desenvolvedora_id',
        'user_id',
        'imagem_url',
    ];

    protected function casts(): array
    {
        return [
            'data_lancamento' => 'date',
            'horas_jogadas' => 'integer',
            'nota' => 'decimal:1',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function plataforma(): BelongsTo
    {
        return $this->belongsTo(Plataforma::class);
    }

    public function genero(): BelongsTo
    {
        return $this->belongsTo(Genero::class);
    }

    public function desenvolvedora(): BelongsTo
    {
        return $this->belongsTo(Desenvolvedora::class);
    }

    public function scopeDoUsuario(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    public function scopePesquisar(Builder $query, ?string $termo): Builder
    {
        if (blank($termo)) {
            return $query;
        }

        return $query->where(function (Builder $subQuery) use ($termo) {
            $subQuery
                ->where('titulo', 'like', '%' . $termo . '%')
                ->orWhere('descricao', 'like', '%' . $termo . '%');
        });
    }

    public function scopeFiltrar(Builder $query, array $filtros): Builder
    {
        return $query
            ->when(filled($filtros['status'] ?? null), fn (Builder $builder) => $builder->where('status', $filtros['status']))
            ->when(filled($filtros['plataforma_id'] ?? null), fn (Builder $builder) => $builder->where('plataforma_id', $filtros['plataforma_id']))
            ->when(filled($filtros['genero_id'] ?? null), fn (Builder $builder) => $builder->where('genero_id', $filtros['genero_id']))
            ->when(filled($filtros['desenvolvedora_id'] ?? null), fn (Builder $builder) => $builder->where('desenvolvedora_id', $filtros['desenvolvedora_id']));
    }

    public function scopeOrdenar(Builder $query, ?string $ordem): Builder
    {
        return match ($ordem) {
            'titulo_asc' => $query->orderBy('titulo'),
            'titulo_desc' => $query->orderByDesc('titulo'),
            'nota_desc' => $query->orderByDesc('nota')->orderBy('titulo'),
            'mais_jogados' => $query->orderByDesc('horas_jogadas')->orderBy('titulo'),
            default => $query->latest(),
        };
    }
}
