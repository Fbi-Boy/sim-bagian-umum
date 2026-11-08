<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('workflow_approvals', function (Blueprint $t) {
            $t->id();
            $t->foreignId('workflow_instance_id')->constrained()->restrictOnDelete();
            $t->foreignId('workflow_step_id')->constrained()->restrictOnDelete();
            $t->foreignId('assigned_to_user_id')->constrained('users')->restrictOnDelete();
            $t->string('decision', 20)->default('pending');
            $t->text('decision_note')->nullable();
            $t->foreignId('acted_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $t->timestamp('acted_at', 6)->nullable();
            $t->timestamp('due_at', 6)->nullable();
            $t->timestamps(6);
            $t->unique(['workflow_instance_id', 'workflow_step_id', 'assigned_to_user_id'], 'wf_approvals_unique');
        });
    }
    public function down(): void { Schema::dropIfExists('workflow_approvals'); }
};
