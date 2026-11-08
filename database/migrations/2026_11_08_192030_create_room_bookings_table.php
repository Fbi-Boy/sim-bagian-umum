<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('room_bookings', function (Blueprint $t) {
            $t->id();
            $t->string('booking_number', 50)->unique();
            $t->foreignId('room_id')->constrained('rooms')->restrictOnDelete();
            $t->foreignId('event_id')->nullable()
                ->constrained('events')->nullOnDelete();
            $t->foreignId('requester_user_id')
                ->constrained('users')->restrictOnDelete();
            $t->foreignId('requester_unit_id')
                ->constrained('organizational_units')->restrictOnDelete();
            $t->string('purpose', 250);
            $t->unsignedSmallInteger('attendee_count');
            $t->timestamp('starts_at', 6);
            $t->timestamp('ends_at', 6);
            $t->text('setup_notes')->nullable();
            $t->foreignId('workflow_instance_id')->nullable()->unique()
                ->constrained('workflow_instances')->nullOnDelete();
            $t->string('status', 25)->default('submitted');
            $t->timestamp('checked_in_at', 6)->nullable();
            $t->timestamp('checked_out_at', 6)->nullable();
            $t->timestamps(6);

            $t->index(['room_id', 'starts_at', 'ends_at', 'status'], 'rb_room_period_status_idx');
        });

        DB::statement('ALTER TABLE room_bookings ADD CONSTRAINT chk_rb_period CHECK (ends_at > starts_at)');
    }
    public function down(): void { Schema::dropIfExists('room_bookings'); }
};
