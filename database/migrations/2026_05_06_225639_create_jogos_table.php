<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jogos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descricao')->nullable();
            $table->unsignedInteger('horas_jogadas')->default(0);
            $table->decimal('nota', 3, 1)->nullable();
            $table->string('status', 20);
            $table->date('data_lancamento')->nullable();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('plataforma_id')->constrained('plataformas')->restrictOnDelete();
            $table->foreignId('genero_id')->constrained('generos')->restrictOnDelete();
            $table->foreignId('desenvolvedora_id')->constrained('desenvolvedoras')->restrictOnDelete();
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index(['user_id', 'titulo']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jogos');
    }
};
