<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('fee_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., Monthly Fee, Exam Fee
            $table->decimal('amount', 10, 2);
            $table->foreignId('school_class_id')->nullable()->constrained('school_classes')->onDelete('set null'); // Optional: if fee is class-specific
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fee_types');
    }
};