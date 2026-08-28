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
        Schema::create('procurements', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique();
            $table->date('date');
            $table->foreignId('supplier_id')->constrained('suppliers')->restrictOnDelete();
            $table->string('invoice_number');
            $table->foreignId('funding_source_id')->constrained('funding_sources')->restrictOnDelete();
            $table->decimal('total_price', 15, 2)->default(0.00);
            $table->text('description')->nullable();
            $table->text('invoice_photos')->nullable();
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
        Schema::dropIfExists('procurements');
    }
};
