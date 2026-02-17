<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('provider_id')->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->text('description');
            $table->enum('type', ['skis', 'boots', 'jacket']);
            $table->enum('gender', ['male', 'female', 'unisex']);
            $table->decimal('price_per_day', 8, 2);
            $table->string('image')->nullable();
            $table->boolean('available')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('equipment');
    }
};