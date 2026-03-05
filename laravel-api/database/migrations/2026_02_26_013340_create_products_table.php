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
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // bigint unsigned auto increment
            $table->string('name'); // varchar(255)
            $table->text('description')->nullable(); // text, boleh null
            $table->decimal('price', 10, 2); // decimal(10,2)
            $table->integer('stock')->default(0); // int, default 0
            $table->string('image')->nullable(); // varchar(255), nullable
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};