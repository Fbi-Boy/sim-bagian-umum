<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('work_tasks', function (Blueprint $t) {
            $t->id();
            $t->string('task_number', 50)->unique();
            $t->string('title', 180);
            $t->text('description')->nullable();
            $t->string('subject_type', 80)->nullable();
            $t->unsignedBigInteger('subject_id')->nullable();
            $t->foreignId('assigned_to_user_id')->nullable()->constrained('users')->nullOnDelete();
            $t->foreignId('assigned_unit_id')->nullable()
                ->constrained('organizational_units')->nullOnDelete();
            $t->foreignId('assigned_by_user_id')->constrained('users')->restrictOnDelete();
            $t->string('priority', 20)->default('normal');
            $t->string('status', 25)->default('open');
            $t->timestamp('due_at', 6)->nullable();
            $t->timestamp('completed_at', 6)->nullable();
            $t->timestamps(6);
            $t->index(['assigned_to_user_id', 'status', 'due_at']);
            $t->index(['subject_type', 'subject_id']);
        });
    }
    public function down(): void { Schema::dropIfExists('work_tasks'); }
};
