<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('supply_items', function (Blueprint $t) {
            $t->id();
            $t->string('sku', 60)->unique();
            $t->foreignId('supply_category_id')->constrained()->restrictOnDelete();
            // Wajib eksplisit: default inferensi Laravel = `unit_of_measures` (salah).
            // Nama tabel yang benar = `units_of_measure`.
            $t->foreignId('unit_of_measure_id')
                ->constrained('units_of_measure')
                ->restrictOnDelete();
            $t->string('name', 180);
            $t->text('description')->nullable();
            $t->decimal('minimum_stock', 18, 3)->default(0);
            $t->boolean('is_active')->default(true);
            $t->timestamps(6);
        });
    }
    public function down(): void { Schema::dropIfExists('supply_items'); }
};
