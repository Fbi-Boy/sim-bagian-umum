<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('workflow_steps', function (Blueprint $t) {
            $t->id();
            $t->foreignId('workflow_definition_id')->constrained()->restrictOnDelete();
            $t->unsignedSmallInteger('step_order');
            $t->string('step_code', 60);
            $t->string('step_name', 120);
            $t->string('assignee_type', 30);
            $t->foreignId('role_id')->nullable()->constrained()->nullOnDelete();
            $t->foreignId('assigned_user_id')->nullable()->constrained('users')->nullOnDelete();
            $t->foreignId('unit_id')->nullable()
                ->constrained('organizational_units')->nullOnDelete();
            $t->unsignedSmallInteger('required_approvals')->default(1);
            $t->boolean('allow_self_approval')->default(false);
            $t->unsignedInteger('due_in_hours')->nullable();
            $t->timestamps(6);
            $t->unique(['workflow_definition_id', 'step_order']);
        });
    }
    public function down(): void { Schema::dropIfExists('workflow_steps'); }
};
