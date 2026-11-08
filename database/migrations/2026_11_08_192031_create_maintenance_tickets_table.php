<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('maintenance_tickets', function (Blueprint $t) {
            $t->id();
            $t->string('ticket_number', 50)->unique();
            $t->foreignId('target_asset_id')->nullable()
                ->constrained('assets')->nullOnDelete();
            $t->foreignId('target_room_id')->nullable()
                ->constrained('rooms')->nullOnDelete();
            $t->foreignId('reported_by_user_id')
                ->constrained('users')->restrictOnDelete();
            $t->foreignId('organizational_unit_id')->nullable()
                ->constrained('organizational_units')->nullOnDelete();
            $t->string('category', 40);
            $t->string('priority', 20)->default('normal');
            $t->string('title', 180);
            $t->text('description');
            $t->string('status', 25)->default('submitted');
            $t->foreignId('assigned_to_user_id')->nullable()
                ->constrained('users')->nullOnDelete();
            $t->foreignId('verified_by_user_id')->nullable()
                ->constrained('users')->nullOnDelete();
            $t->timestamp('completed_at', 6)->nullable();
            $t->timestamps(6);

            $t->index(['status', 'priority', 'created_at'], 'mt_status_prio_created_idx');
            $t->index(['assigned_to_user_id', 'status'], 'mt_assignee_status_idx');
            $t->index(['target_asset_id', 'created_at'], 'mt_asset_created_idx');
            $t->index(['target_room_id', 'created_at'], 'mt_room_created_idx');
            // Catatan: validasi "tepat satu target aset/ruangan" TIDAK pakai CHECK
            // karena target_asset_id & target_room_id adalah FK SET NULL (MySQL larang).
            // Wajib divalidasi di FormRequest + Action.
        });
    }
    public function down(): void { Schema::dropIfExists('maintenance_tickets'); }
};
