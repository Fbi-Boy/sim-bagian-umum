<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('drivers', function (Blueprint $t) {
            $t->id();
            $t->foreignId('employee_id')->nullable()->unique()
                ->constrained('employees')->nullOnDelete();
            $t->string('driver_name', 180);
            $t->string('license_number', 80)->nullable();
            $t->string('license_class', 30)->nullable();
            $t->date('license_expires_on')->nullable();
            $t->string('phone', 25)->nullable();
            $t->string('status', 20)->default('active');
            $t->timestamps(6);
        });
    }
    public function down(): void { Schema::dropIfExists('drivers'); }
};
