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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title');
            $table->text('content');
            $table->boolean('published')->default(true);
            $table->timestamp('published_at')->nullable();

            // $table->bigInteger('category_id')->unsigned()->nullable();
            // $table->bigInteger('user_id')->unsigned()->nullable();
            // $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            // now the same, but shorter:
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
