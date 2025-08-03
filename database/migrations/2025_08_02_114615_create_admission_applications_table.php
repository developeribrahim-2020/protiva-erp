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
        Schema::create('admission_applications', function (Blueprint $table) {
            $table->id();
            
            // Student's Information
            $table->string('student_name');
            $table->date('date_of_birth');
            $table->string('gender');
            $table->string('student_image')->nullable();
            
            // Class Information
            $table->string('class_to_apply'); // e.g., "Class Five"
            
            // Guardian's Information
            $table->string('father_name');
            $table->string('mother_name');
            $table->string('guardian_phone');
            $table->string('guardian_email')->nullable();
            $table->text('present_address');
            $table->text('permanent_address');
            
            // Application Status
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admission_applications');
    }
};