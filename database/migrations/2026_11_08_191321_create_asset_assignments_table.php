<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('asset_assignments', function (Blueprint $t) {
            $t->id();
            $t->foreignId('asset_id')->constrained()->restrictOnDelete();
            $t->foreignId('employee_id')->constrained()->restrictOnDelete();
            $t->foreignId('organizational_unit_id')->constrained()->restrictOnDelete();
            $t->foreignId('assigned_by_user_id')->constrained('users')->restrictOnDelete();
            $t->timestamp('starts_at', 6);
            $t->timestamp('ends_at', 6)->nullable();
            $t->text('assignment_note')->nullable();
            $t->timestamps(6);

            $t->index(['asset_id', 'starts_at', 'ends_at'], 'aa_asset_period_idx');
            $t->index(['employee_id', 'ends_at'], 'aa_emp_end_idx');
        });
    }
    public function down(): void { Schema::dropIfExists('asset_assignments'); }
};
