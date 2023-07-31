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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('client');
            $table->string('job');
            $table->string('logo');
            $table->string('url')->nullable();
            $table->string('github')->nullable();
            $table->text('description');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('illustration_1')->nullable();
            $table->string('illustration_2')->nullable();
            $table->string('illustration_3')->nullable();
            $table->string('illustration_4')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->boolean('is_printable')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
