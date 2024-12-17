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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->dateTime('due_date')->nullable();
            $table->enum('priority', ['high', 'medium', 'low'])->default('medium');
            $table->boolean('is_completed')->default(false);
            $table->timestamps();

            // Add index for common queries
            $table->index('due_date');
            $table->index('priority');
            $table->index('is_completed');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};