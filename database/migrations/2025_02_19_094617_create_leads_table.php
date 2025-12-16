<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id('lead_id'); // Auto-increment primary key
            // $table->timestamp('received_date')->useCurrent(); // Auto-generated on creation
            // $table->date('follow_up_date'); // Mandatory field
            // $table->string('customer_name', 100);
            // $table->string('email', 100)->unique();
            // $table->string('country', 50);
            // $table->string('contact_number', 20);
            // $table->string('website', 255)->nullable();
            // $table->string('lead_source', 50); // Dropdown options
            // $table->string('service_required', 50); // Dropdown options
            // $table->enum('status', ['New', 'Contacted', 'Qualified', 'Converted', 'Lost'])->default('New');
            // $table->string('linkedin_profile', 255)->nullable();
            // $table->unsignedBigInteger('assigned_to'); // Foreign key reference
            // $table->timestamps();
            $table->string('customer_name');
            $table->string('contact_number')->nullable();
            
            $table->text('site_address')->nullable();
            $table->string('city')->nullable();
            $table->string('property_type')->nullable();
            $table->string('site_area')->nullable();
            $table->integer('num_cameras')->nullable();
            $table->string('camera_type')->nullable();
            $table->text('features')->nullable(); // store JSON or CSV
            $table->string('installation_required')->nullable();
            $table->dateTime('preferred_date')->nullable();
            $table->string('budget')->nullable();
            $table->string('lead_source')->nullable();
            $table->string('status')->default('New');
            $table->dateTime('follow_up_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
