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
        Schema::disableForeignKeyConstraints();
        Schema::create('popup_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('popup_id')->constrained('popups')->onDelete('cascade');
            $table->string('name');
            $table->json('content');    // JSON content for each variant
            $table->boolean('is_primary');  // Whether this variant is primary for A/B testing
            $table->timestamps();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('popup_variants');
    }
};
