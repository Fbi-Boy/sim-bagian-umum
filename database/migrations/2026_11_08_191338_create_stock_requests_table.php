<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('stock_requests', function (Blueprint $t) {
            $t->id();
            $t->string('request_number', 50)->unique();
            $t->foreignId('requester_user_id')->constrained('users')->restrictOnDelete();
            $t->foreignId('requester_unit_id')->constrained('organizational_units')->restrictOnDelete();
            $t->foreignId('destination_location_id')->nullable()
                ->constrained('locations')->nullOnDelete();
            $t->text('purpose');
            $t->timestamp('needed_at', 6)->nullable();
            $t->foreignId('workflow_instance_id')->nullable()->unique()
                ->constrained('workflow_instances')->nullOnDelete();
            $t->string('status', 25)->default('draft');
            $t->timestamps(6);

            $t->index(['requester_unit_id', 'status', 'created_at'], 'sr_unit_status_created_idx');
        });
    }
    public function down(): void { Schema::dropIfExists('stock_requests'); }
};
