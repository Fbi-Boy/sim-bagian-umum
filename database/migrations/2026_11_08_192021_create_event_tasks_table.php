<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('event_tasks', function (Blueprint $t) {
            $t->id();
            $t->foreignId('event_id')->constrained('events')->restrictOnDelete();
            $t->string('task_title', 180);
            $t->text('description')->nullable();
            $t->foreignId('responsible_unit_id')->nullable()
                ->constrained('organizational_units')->nullOnDelete();
            $t->foreignId('assigned_to_user_id')->nullable()
                ->constrained('users')->nullOnDelete();
            $t->timestamp('due_at', 6)->nullable();
            $t->string('priority', 20)->default('normal');
            $t->string('status', 25)->default('open');
            $t->timestamp('completed_at', 6)->nullable();
            $t->foreignId('created_by_user_id')
                ->constrained('users')->restrictOnDelete();
            $t->timestamps(6);

            $t->index(['event_id', 'status'], 'et_event_status_idx');
            $t->index(['assigned_to_user_id', 'status'], 'et_user_status_idx');
            // Catatan: validasi "minimal salah satu assignee" dilakukan di FormRequest/Action
            // karena kolom assignee adalah FK SET NULL (MySQL larang CHECK di kolom FK SET NULL).
        });
    }
    public function down(): void { Schema::dropIfExists('event_tasks'); }
};
