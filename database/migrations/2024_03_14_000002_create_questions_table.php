<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['multiple_choice', 'single_selection', 'short_answer', 'paragraph']);
            $table->text('text');
            $table->json('options')->nullable();
            $table->string('correct_answer')->nullable();
            $table->integer('word_limit')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('questions');
    }
};