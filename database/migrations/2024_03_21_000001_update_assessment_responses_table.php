<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasTable('assessment_responses')) {
            Schema::dropIfExists('question_responses');
            Schema::dropIfExists('assessment_responses');
        }

        Schema::create('assessment_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('employees')->onDelete('cascade');
            $table->foreignId('assessment_id')->constrained()->onDelete('cascade');
            $table->timestamp('started_at');
            $table->timestamp('completed_at')->nullable();
            $table->float('score')->nullable();
            $table->string('status');
            $table->timestamps();

            $table->index(['user_id', 'assessment_id']);
            $table->index('status');
        });

        Schema::create('question_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_response_id')->constrained()->onDelete('cascade');
            $table->foreignId('question_id')->constrained()->onDelete('cascade');
            $table->text('answer');
            $table->boolean('is_correct')->nullable();
            $table->float('score')->nullable();
            $table->timestamps();

            $table->index(['assessment_response_id', 'question_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('question_responses');
        Schema::dropIfExists('assessment_responses');
    }
};