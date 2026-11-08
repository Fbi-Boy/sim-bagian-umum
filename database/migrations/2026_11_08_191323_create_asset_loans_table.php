<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('asset_loans', function (Blueprint $t) {
            $t->id();
            $t->string('loan_number', 50)->unique();
            $t->foreignId('requester_user_id')->constrained('users')->restrictOnDelete();
            $t->foreignId('requester_unit_id')->constrained('organizational_units')->restrictOnDelete();
            $t->text('purpose');
            $t->timestamp('starts_at', 6);
            $t->timestamp('expected_return_at', 6);
            $t->foreignId('workflow_instance_id')->nullable()->unique()
                ->constrained('workflow_instances')->nullOnDelete();
            $t->string('status', 25)->default('draft');
            $t->foreignId('handed_over_by_user_id')->nullable()
                ->constrained('users')->nullOnDelete();
            $t->timestamp('handed_over_at', 6)->nullable();
            $t->timestamps(6);

            $t->index(['requester_unit_id', 'status'], 'al_unit_status_idx');
            $t->index(['status', 'expected_return_at'], 'al_status_due_idx');
        });
    }
    public function down(): void { Schema::dropIfExists('asset_loans'); }
};
