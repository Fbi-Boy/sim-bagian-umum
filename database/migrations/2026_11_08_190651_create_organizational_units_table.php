<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('organizational_units', function (Blueprint $t) {
            $t->id();
            $t->foreignId('parent_id')->nullable()->constrained('organizational_units')->nullOnDelete();
            $t->string('code', 40)->unique();
            $t->string('name', 160);
            $t->string('unit_type', 40);
            $t->text('description')->nullable();
            $t->boolean('is_active')->default(true);
            $t->date('effective_from')->nullable();
            $t->date('effective_until')->nullable();
            $t->timestamps(6);
            $t->index(['is_active', 'name']);
        });
    }
    public function down(): void { Schema::dropIfExists('organizational_units'); }
};
