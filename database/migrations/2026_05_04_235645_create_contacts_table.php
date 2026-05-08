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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('entreprise')->nullable();
            $table->string('email')->unique();
            $table->string('telephone')->nullable();
            $table->string('source')->nullable(); // e.g., 'website', 'referral'
            $table->integer('score')->default(0);
            $table->json('tags')->nullable(); // array of tags
            $table->enum('statut', ['prospect', 'client', 'ancien_client'])->default('prospect');
            $table->foreignId('commercial_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
