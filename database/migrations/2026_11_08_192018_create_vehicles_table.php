<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('vehicles', function (Blueprint $t) {
            $t->id();
            $t->foreignId('asset_id')->unique()->constrained('assets')->restrictOnDelete();
            $t->string('vehicle_code', 50)->unique();
            $t->string('license_plate', 20)->unique();
            $t->string('make', 80)->nullable();
            $t->string('model', 100)->nullable();
            $t->unsignedSmallInteger('manufacture_year')->nullable();
            $t->unsignedSmallInteger('passenger_capacity')->nullable();
            $t->string('fuel_type', 25)->nullable();
            $t->date('tax_valid_until')->nullable();
            $t->date('registration_valid_until')->nullable();
            $t->string('vehicle_status', 25)->default('available');
            $t->timestamps(6);

            $t->index(['vehicle_status', 'tax_valid_until'], 'veh_status_tax_idx');
        });
    }
    public function down(): void { Schema::dropIfExists('vehicles'); }
};
