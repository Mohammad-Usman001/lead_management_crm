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
        // Schema::table('complaint_images', function (Blueprint $table) {
        //     //
        // });
         // Only create if not exists (defensive)
        if (!Schema::hasTable('complaint_images')) {
            Schema::create('complaint_images', function (Blueprint $table) {
                $table->id();
                // complaint_id must reference complaints.id — make nullable only if you prefer
                $table->foreignId('complaint_id')
                      ->constrained('complaints')
                      ->cascadeOnDelete();

                $table->string('path');           // storage path e.g. "complaints/filename.png"
                $table->string('original_name')->nullable();
                $table->timestamps();

                // index for faster lookup if needed
                $table->index('complaint_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('complaint_images', function (Blueprint $table) {
        //     //
        // });
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('complaint_images');
        Schema::enableForeignKeyConstraints();
    }
};
