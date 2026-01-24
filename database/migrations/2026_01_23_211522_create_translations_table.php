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
        Schema::create('translations', function (Blueprint $table) {
            $table->id();
            $table->string('translatable_type'); // Model class (Service, Blog, Section, Slider)
            $table->unsignedBigInteger('translatable_id'); // Model ID
            $table->string('locale', 5); // mk, en
            $table->string('field'); // title, description, content, etc.
            $table->text('value')->nullable();
            $table->timestamps();

            $table->index(['translatable_type', 'translatable_id', 'locale'], 'trans_model_locale_idx');
            $table->unique(['translatable_type', 'translatable_id', 'locale', 'field'], 'trans_unique_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('translations');
    }
};
