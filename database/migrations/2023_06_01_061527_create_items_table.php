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
            $table->foreignId('unit_id')->references('id')->on('units')->constrained()->cascadeOnDelete();
            $table->string('code')->unique();
            $table->string('name');
            $table->bigInteger('price');
            $table->string('desc');
            $table->integer('stock');
            $table->string('image_item')->nullable();
            $table->timestamps();
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
