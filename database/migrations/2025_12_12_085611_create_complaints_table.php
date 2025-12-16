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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->nullable()->constrained('leads')->nullOnDelete();
            $table->string('customer_name');
            $table->string('contact_number')->nullable();
            $table->text('site_address')->nullable();
            $table->string('city')->nullable();
            $table->string('location_detail')->nullable(); // eg. "Main gate - left pillar"
            $table->string('device_type')->nullable();     // e.g., "2.4MP Camera", "DVR"
            $table->string('serial_number')->nullable();
            $table->text('issue_description')->nullable();
            $table->enum('priority', ['Low','Medium','High'])->default('Medium');
            $table->enum('status', ['New','Assigned','In Progress','Resolved','Closed','Rejected'])->default('New');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('reported_at')->nullable();
            $table->dateTime('scheduled_visit')->nullable();
            $table->text('technician_notes')->nullable();
            $table->timestamps();
        });

        Schema::create('complaint_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('complaint_id')->constrained('complaints')->cascadeOnDelete();
            $table->string('path');
            $table->string('original_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaint_images');
        Schema::dropIfExists('complaints');
    }
};
