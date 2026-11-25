<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('marcas', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 80)->unique();
        });

        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 80)->unique();
        });

        Schema::create('relogios', function (Blueprint $table) {
            $table->id();
            $table->string('referencia', 50)->unique();
            $table->foreignId('marca_id')->constrained('marcas')->restrictOnDelete();
            $table->foreignId('categoria_id')->constrained('categorias')->restrictOnDelete();
            $table->string('modelo', 100);
            $table->text('descricao')->nullable();
            $table->decimal('preco', 12, 2);
            $table->enum('tipo_movimento', ['quartzo', 'automatico', 'mecanico']);
            $table->string('material_caixa', 60)->nullable();
            $table->string('material_bracelete', 60)->nullable();
            $table->unsignedInteger('diametro_mm')->nullable();
            $table->unsignedInteger('resistencia_agua_m')->nullable();
            $table->enum('genero', ['masculino', 'feminino', 'unissexo']);
            $table->string('cor_mostrador', 40)->nullable();
            $table->unsignedInteger('garantia_meses');
            $table->unsignedInteger('stock')->default(0);
            $table->string('imagem', 255)->nullable();
            $table->enum('estado', ['disponivel', 'indisponivel'])->default('disponivel');
        });

        Schema::create('compras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('utilizador_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('relogio_id')->constrained('relogios')->restrictOnDelete();
            $table->decimal('valor_total', 12, 2);
            $table->enum('estado', ['pendente', 'aprovada', 'rejeitada', 'concluida', 'cancelada'])
                ->default('pendente');
            $table->string('motivo_rejeicao', 255)->nullable();
            $table->string('numero_serie', 60)->unique();
            $table->date('inicio_garantia')->nullable();
            $table->dateTime('data_compra');
        });

        Schema::create('faturas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('compra_id')->unique()->constrained('compras')->restrictOnDelete();
            $table->unsignedInteger('numero')->unique();
            $table->date('data_emissao');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('faturas');
        Schema::dropIfExists('compras');
        Schema::dropIfExists('relogios');
        Schema::dropIfExists('categorias');
        Schema::dropIfExists('marcas');
    }
};
