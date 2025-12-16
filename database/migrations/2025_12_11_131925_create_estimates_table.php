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
        Schema::create('estimates', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no')->nullable();
            $table->date('date')->nullable();
            $table->string('client_name')->nullable();
            $table->text('client_address')->nullable();
            $table->string('client_phone')->nullable();
            $table->string('email')->nullable();
            $table->string('gst')->nullable();
            $table->decimal('sub_total', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estimates');
    }
};
