<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('asset_movements', function (Blueprint $t) {
            $t->id();
            $t->foreignId('asset_id')->constrained()->restrictOnDelete();
            $t->foreignId('from_location_id')->nullable()
                ->constrained('locations')->nullOnDelete();
            $t->foreignId('to_location_id')->nullable()
                ->constrained('locations')->nullOnDelete();
            $t->foreignId('from_employee_id')->nullable()
                ->constrained('employees')->nullOnDelete();
            $t->foreignId('to_employee_id')->nullable()
                ->constrained('employees')->nullOnDelete();
            $t->string('movement_type', 30);
            $t->text('reason');
            $t->timestamp('moved_at', 6);
            $t->foreignId('recorded_by_user_id')->constrained('users')->restrictOnDelete();
            $t->foreignId('approved_by_user_id')->nullable()
                ->constrained('users')->nullOnDelete();
            $t->timestamp('created_at', 6)->useCurrent();

            $t->index(['asset_id', 'moved_at'], 'am_asset_moved_idx');
        });
    }
    public function down(): void { Schema::dropIfExists('asset_movements'); }
};
