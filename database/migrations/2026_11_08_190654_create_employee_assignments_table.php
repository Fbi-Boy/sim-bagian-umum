<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('employee_assignments', function (Blueprint $t) {
            $t->id();
            $t->foreignId('employee_id')->constrained()->restrictOnDelete();
            $t->foreignId('organizational_unit_id')->constrained()->restrictOnDelete();
            $t->foreignId('position_id')->nullable()->constrained()->nullOnDelete();
            $t->string('assignment_type', 30)->default('utama');
            $t->date('starts_on');
            $t->date('ends_on')->nullable();
            $t->boolean('is_primary')->default(true);
            $t->string('reference_number', 100)->nullable();
            $t->timestamps(6);

            // Nama index dipendekkan agar < 64 karakter (MySQL limit)
            $t->index(['employee_id', 'starts_on', 'ends_on'], 'ea_employee_period_idx');
            $t->index(['organizational_unit_id', 'starts_on', 'ends_on'], 'ea_unit_period_idx');
        });
    }
    public function down(): void { Schema::dropIfExists('employee_assignments'); }
};
