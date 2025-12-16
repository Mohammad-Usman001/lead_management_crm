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
        Schema::table('project_material_logs', function (Blueprint $table) {
            $table->string('item_name')->after('technician_id');
            $table->dropForeign(['item_id']);
            $table->dropColumn('item_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_material_logs', function (Blueprint $table) {
            $table->unsignedBigInteger('item_id')->nullable();
            $table->dropColumn('item_name');
        });
    }
};
