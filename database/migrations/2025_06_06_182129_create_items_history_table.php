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
        Schema::create('items_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->references('id')->on('items')->cascadeOnDelete();
            $table->decimal('old_price')->default(0);
            $table->decimal('new_price')->default(0);
            $table->string('old_price_text')->nullable();
            $table->string('new_price_text')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items_history');
    }
};
