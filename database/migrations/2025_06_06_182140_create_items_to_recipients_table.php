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
        Schema::create('items_to_recipients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->references('id')->on('items')->cascadeOnDelete();
            $table->foreignId('recipient_id')->references('id')->on('recipients')->cascadeOnDelete();

            $table->unique([ 'item_id', 'recipient_id' ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items_to_recipients');
    }
};
