<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('assets', function (Blueprint $t) {
            $t->id();
            $t->char('public_id', 26)->unique();
            $t->string('asset_code', 60)->unique();
            $t->string('official_bmd_code', 80)->nullable();
            $t->foreignId('asset_category_id')->constrained()->restrictOnDelete();
            $t->string('name', 180);
            $t->string('brand', 100)->nullable();
            $t->string('model', 100)->nullable();
            $t->string('serial_number', 120)->nullable();
            $t->string('asset_scope', 25)->default('operational');
            $t->date('acquisition_date')->nullable();
            $t->string('acquisition_source', 100)->nullable();
            $t->decimal('acquisition_value', 18, 2)->nullable();
            $t->string('condition', 25)->default('good');
            $t->string('status', 25)->default('available');
            $t->foreignId('location_id')->nullable()
                ->constrained('locations')->nullOnDelete();
            $t->foreignId('responsible_unit_id')->nullable()
                ->constrained('organizational_units')->nullOnDelete();
            $t->foreignId('custodian_employee_id')->nullable()
                ->constrained('employees')->nullOnDelete();
            $t->string('qr_code_value', 100)->unique();
            $t->text('notes')->nullable();
            $t->foreignId('created_by_user_id')->constrained('users')->restrictOnDelete();
            $t->timestamps(6);

            $t->index(['location_id', 'status'], 'assets_loc_status_idx');
            $t->index(['responsible_unit_id', 'condition'], 'assets_unit_cond_idx');
        });
    }
    public function down(): void { Schema::dropIfExists('assets'); }
};
