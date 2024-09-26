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
        Schema::create('popup_analytics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('popup_id')->constrained('popups')->onDelete('cascade');
            $table->foreignId('variant_id')->constrained('popup_variants')->onDelete('cascade');
            $table->unsignedBigInteger('views')->default(0);
            $table->unsignedBigInteger('clicks')->default(0);
            $table->unsignedBigInteger('conversions')->default(0);
            $table->enum('device_type', ['desktop', 'mobile']);
            $table->string('page_url');
            $table->timestamps();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('popup_analytics');
    }
};
