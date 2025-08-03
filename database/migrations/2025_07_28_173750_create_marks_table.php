<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void
    {
        Schema::create('marks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('exam_id')->constrained('exams')->onDelete('cascade');
            $table->foreignId('school_class_id')->constrained('school_classes')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');
            
            $table->integer('marks')->nullable(); // প্রাপ্ত নম্বর
            
            $table->timestamps();

            // Ensure a unique entry for each student, exam, and subject combination
            $table->unique(['student_id', 'exam_id', 'subject_id']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('marks');
    }
};