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
        Schema::create('item_exits', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('item_id')->constrained('items')->restrictOnDelete();
            $table->integer('quantity');
            $table->string('destination');
            $table->string('pic');
            $table->text('description')->nullable();
            $table->foreignId('created_by')->constrained('users')->restrictOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_exits');
    }
};
