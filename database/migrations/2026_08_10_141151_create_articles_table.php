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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->string('nom');
            $table->text('description')->nullable();
            $table->foreignId('categorie_id')->nullable()
                ->constrained('categories')->onDelete('set null');
            $table->decimal('prix_achat', 10, 2);
            $table->decimal('prix_vente', 10, 2);
            $table->integer('stock_actuel')->default(0);
            $table->integer('stock_minimum')->default(5);
            $table->string('unite', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
