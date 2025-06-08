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
        Schema::create('items_information', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->references('id')->on('items')->cascadeOnDelete();
            $table->string('name');
            $table->string('url')->unique();
            $table->string('image')->nullable();
            $table->longText('note')->nullable();
            $table->string('currency')->nullable();
            $table->json('parameters')->default('[]');
            $table->string('publicate_at')->nullable()->index();;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items_information');
    }
};
