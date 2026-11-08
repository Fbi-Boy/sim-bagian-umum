<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('locations', function (Blueprint $t) {
            $t->id();
            $t->foreignId('parent_id')->nullable()->constrained('locations')->nullOnDelete();
            $t->foreignId('organizational_unit_id')->nullable()
                ->constrained('organizational_units')->nullOnDelete();
            $t->string('code', 50)->unique();
            $t->string('name', 160);
            $t->string('location_type', 30);
            $t->string('address_detail', 255)->nullable();
            $t->boolean('is_active')->default(true);
            $t->timestamps(6);
        });
    }
    public function down(): void { Schema::dropIfExists('locations'); }
};
