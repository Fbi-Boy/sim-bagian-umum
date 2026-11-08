<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('vehicle_assignments', function (Blueprint $t) {
            $t->id();
            $t->foreignId('vehicle_request_id')
                ->constrained('vehicle_requests')->restrictOnDelete();
            $t->foreignId('vehicle_id')->constrained('vehicles')->restrictOnDelete();
            $t->foreignId('driver_id')->constrained('drivers')->restrictOnDelete();
            $t->foreignId('assigned_by_user_id')
                ->constrained('users')->restrictOnDelete();
            $t->timestamp('planned_start_at', 6);
            $t->timestamp('planned_end_at', 6);
            $t->timestamp('actual_start_at', 6)->nullable();
            $t->timestamp('actual_end_at', 6)->nullable();
            $t->decimal('odometer_start', 12, 1)->nullable();
            $t->decimal('odometer_end', 12, 1)->nullable();
            $t->string('status', 20)->default('assigned');
            $t->timestamps(6);

            $t->index(['vehicle_id', 'planned_start_at', 'planned_end_at'], 'va_veh_period_idx');
            $t->index(['driver_id', 'planned_start_at', 'planned_end_at'], 'va_drv_period_idx');
        });

        DB::statement('ALTER TABLE vehicle_assignments ADD CONSTRAINT chk_va_period CHECK (planned_end_at > planned_start_at)');
    }
    public function down(): void { Schema::dropIfExists('vehicle_assignments'); }
};
