<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('workflow_instances', function (Blueprint $t) {
            $t->id();
            $t->foreignId('workflow_definition_id')->constrained()->restrictOnDelete();
            $t->string('source_type', 80);
            $t->unsignedBigInteger('source_id');
            $t->foreignId('submitted_by')->constrained('users')->restrictOnDelete();
            $t->foreignId('current_step_id')->nullable()
                ->constrained('workflow_steps')->nullOnDelete();
            $t->string('status', 30)->default('pending');
            $t->timestamp('submitted_at', 6)->nullable();
            $t->timestamp('completed_at', 6)->nullable();
            $t->timestamp('cancelled_at', 6)->nullable();
            $t->timestamps(6);
            $t->index(['source_type', 'source_id']);
            $t->index(['status', 'submitted_at']);
        });
    }
    public function down(): void { Schema::dropIfExists('workflow_instances'); }
};
