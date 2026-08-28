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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->foreignId('category_id')->constrained('categories')->restrictOnDelete();
            $table->string('brand')->nullable();
            $table->text('specification')->nullable();
            $table->string('unit')->default('pcs');
            $table->integer('min_stock')->default(0);
            $table->foreignId('location_id')->constrained('locations')->restrictOnDelete();
            $table->integer('stock')->default(0);
            $table->text('description')->nullable();
            $table->string('photo_path')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
