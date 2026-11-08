<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('official_travel_requests', function (Blueprint $t) {
            $t->id();
            $t->string('request_number', 50)->unique();
            $t->foreignId('requester_employee_id')
                ->constrained('employees')->restrictOnDelete();
            $t->foreignId('requester_unit_id')
                ->constrained('organizational_units')->restrictOnDelete();
            $t->foreignId('event_id')->nullable()
                ->constrained('events')->nullOnDelete();
            $t->text('purpose');
            $t->string('destination', 255);
            $t->timestamp('departure_at', 6);
            $t->timestamp('return_at', 6);
            $t->string('transport_mode', 30)->nullable();
            $t->foreignId('workflow_instance_id')->nullable()->unique()
                ->constrained('workflow_instances')->nullOnDelete();
            $t->string('status', 25)->default('draft');
            $t->foreignId('created_by_user_id')
                ->constrained('users')->restrictOnDelete();
            $t->timestamps(6);

            $t->index(['requester_employee_id', 'departure_at'], 'otr_emp_dep_idx');
            $t->index(['status', 'created_at'], 'otr_status_created_idx');
        });

        DB::statement('ALTER TABLE official_travel_requests ADD CONSTRAINT chk_otr_period CHECK (return_at > departure_at)');
    }
    public function down(): void { Schema::dropIfExists('official_travel_requests'); }
};
