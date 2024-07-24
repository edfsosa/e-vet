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
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->string('name', 60);
            $table->string('species', 30);
            $table->string('breed', 30);
            $table->enum('gender', ['Male', 'Female']);
            $table->date('birthdate');
            $table->enum('size', ['Giant', 'Big', 'Medium', 'Small', 'Tiny']);
            $table->double('weight');
            $table->string('fur');
            $table->enum('reproduction', ['Normal', 'Castrated', 'Sterilized']);
            $table->boolean('active')->default(true);
            $table->string('image');
            $table->foreignId('owner_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};
