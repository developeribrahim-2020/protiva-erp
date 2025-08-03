<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('school_class_id')->constrained('school_classes')->onDelete('cascade');
            $table->date('attendance_date');
            $table->enum('status', ['present', 'absent', 'late'])->default('absent');
            $table->timestamps();
            // একটি নির্দিষ্ট তারিখে একজন ছাত্রের জন্য শুধুমাত্র একটি এন্ট্রি থাকবে
            $table->unique(['student_id', 'attendance_date']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('attendances');
    }
};