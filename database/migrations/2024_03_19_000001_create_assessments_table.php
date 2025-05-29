<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedTinyInteger('month');
            $table->year('year');
            $table->text('description')->nullable();
            $table->unsignedInteger('duration')->comment('Duration in minutes');
            $table->unsignedTinyInteger('passing_score');
            $table->boolean('is_published')->default(false);
            $table->timestamps();
            
            // Add indexes for common queries
            $table->index(['month', 'year']);
            $table->index('is_published');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessments');
    }
};