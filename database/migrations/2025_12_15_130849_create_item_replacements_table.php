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
        Schema::create('item_replacements', function (Blueprint $table) {
            $table->id();
            $table->string('client_name');
            $table->string('deposited_by')->nullable();
            $table->date('deposit_date');
            $table->json('items');
            $table->integer('quantity');
            $table->date('replacement_date')->nullable();
            $table->string('status')->default('Pending'); // Pending / Replaced
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_replacements');
    }
};
