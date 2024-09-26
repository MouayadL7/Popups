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
        Schema::create('popup_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('variant_id')->constrained('popup_variants')->onDelete('cascade');
            $table->integer('time_delay')->default(0);
            $table->json('display_pages');
            $table->timestamps();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('popup_schedules');
    }
};
