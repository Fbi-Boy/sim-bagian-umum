<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('events', function (Blueprint $t) {
            $t->id();
            $t->char('public_id', 26)->unique();
            $t->string('event_number', 50)->unique();
            $t->string('title', 220);
            $t->string('event_type', 40);
            $t->foreignId('organizing_unit_id')
                ->constrained('organizational_units')->restrictOnDelete();
            $t->foreignId('coordinator_user_id')
                ->constrained('users')->restrictOnDelete();
            $t->timestamp('starts_at', 6);
            $t->timestamp('ends_at', 6);
            $t->foreignId('location_id')->nullable()
                ->constrained('locations')->nullOnDelete();
            $t->string('location_text', 255)->nullable();
            $t->text('description')->nullable();
            $t->string('status', 25)->default('draft');
            $t->foreignId('created_by_user_id')
                ->constrained('users')->restrictOnDelete();
            $t->timestamps(6);

            $t->index(['starts_at', 'status'], 'ev_start_status_idx');
            $t->index(['organizing_unit_id', 'starts_at'], 'ev_unit_start_idx');
        });

        // CHECK aman: starts_at & ends_at bukan FK
        DB::statement('ALTER TABLE events ADD CONSTRAINT chk_ev_period CHECK (ends_at > starts_at)');
    }
    public function down(): void { Schema::dropIfExists('events'); }
};
