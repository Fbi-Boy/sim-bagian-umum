<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('vehicle_usage_logs', function (Blueprint $t) {
            $t->id();
            $t->foreignId('vehicle_assignment_id')
                ->constrained('vehicle_assignments')->restrictOnDelete();
            $t->string('event_type', 25);
            $t->timestamp('happened_at', 6);
            $t->decimal('odometer', 12, 1)->nullable();
            $t->text('note')->nullable();
            $t->foreignId('recorded_by_user_id')
                ->constrained('users')->restrictOnDelete();
            $t->timestamp('created_at', 6)->useCurrent();

            $t->index(['vehicle_assignment_id', 'happened_at'], 'vul_assign_at_idx');
        });
    }
    public function down(): void { Schema::dropIfExists('vehicle_usage_logs'); }
};
