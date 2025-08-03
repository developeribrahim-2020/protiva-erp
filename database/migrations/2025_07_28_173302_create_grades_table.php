<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->string('grade_name'); // e.g., A+, A, A-, B
            $table->string('grade_point'); // e.g., 5.00, 4.00
            $table->integer('mark_from'); // e.g., 80
            $table->integer('mark_to'); // e.g., 100
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};