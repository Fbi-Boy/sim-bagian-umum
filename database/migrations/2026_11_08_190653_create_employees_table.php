<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('employees', function (Blueprint $t) {
            $t->id();
            $t->string('employee_number', 50)->unique();
            $t->string('full_name', 180);
            $t->string('email', 190)->nullable()->index();
            $t->string('phone', 25)->nullable();
            $t->string('employment_status', 30)->default('aktif');
            $t->date('joined_at')->nullable();
            $t->date('left_at')->nullable();
            $t->timestamps(6);
        });
    }
    public function down(): void { Schema::dropIfExists('employees'); }
};
