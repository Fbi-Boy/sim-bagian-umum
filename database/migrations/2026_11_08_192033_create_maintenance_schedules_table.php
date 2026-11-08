<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('maintenance_schedules', function (Blueprint $t) {
            $t->id();
            $t->foreignId('target_asset_id')->nullable()
                ->constrained('assets')->nullOnDelete();
            $t->foreignId('target_room_id')->nullable()
                ->constrained('rooms')->nullOnDelete();
            $t->string('title', 180);
            $t->text('description')->nullable();
            $t->string('frequency_type', 20);
            $t->unsignedSmallInteger('interval_value')->default(1);
            $t->timestamp('next_due_at', 6);
            $t->timestamp('last_completed_at', 6)->nullable();
            $t->foreignId('assigned_to_user_id')->nullable()
                ->constrained('users')->nullOnDelete();
            $t->boolean('is_active')->default(true);
            $t->timestamps(6);

            $t->index(['is_active', 'next_due_at'], 'ms_active_due_idx');
            // Validasi "tepat satu target" di FormRequest + Action (alasan sama).
        });
    }
    public function down(): void { Schema::dropIfExists('maintenance_schedules'); }
};
