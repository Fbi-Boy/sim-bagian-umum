<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('vehicle_requests', function (Blueprint $t) {
            $t->id();
            $t->string('request_number', 50)->unique();
            $t->foreignId('requester_user_id')
                ->constrained('users')->restrictOnDelete();
            $t->foreignId('requester_unit_id')
                ->constrained('organizational_units')->restrictOnDelete();
            $t->foreignId('event_id')->nullable()
                ->constrained('events')->nullOnDelete();
            $t->foreignId('official_travel_request_id')->nullable()
                ->constrained('official_travel_requests')->nullOnDelete();
            $t->text('purpose');
            $t->string('destination', 255);
            $t->string('pickup_location', 255)->nullable();
            $t->timestamp('starts_at', 6);
            $t->timestamp('ends_at', 6);
            $t->unsignedSmallInteger('passenger_count')->default(1);
            $t->foreignId('workflow_instance_id')->nullable()->unique()
                ->constrained('workflow_instances')->nullOnDelete();
            $t->string('status', 25)->default('draft');
            $t->timestamps(6);

            $t->index(['starts_at', 'ends_at', 'status'], 'vr_start_end_status_idx');
            $t->index(['requester_user_id', 'created_at'], 'vr_user_created_idx');
        });
    }
    public function down(): void { Schema::dropIfExists('vehicle_requests'); }
};
