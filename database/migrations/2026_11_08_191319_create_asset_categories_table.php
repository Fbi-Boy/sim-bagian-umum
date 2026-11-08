<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('asset_categories', function (Blueprint $t) {
            $t->id();
            $t->foreignId('parent_id')->nullable()
                ->constrained('asset_categories')->nullOnDelete();
            $t->string('code', 40)->unique();
            $t->string('name', 140);
            $t->text('description')->nullable();
            $t->boolean('is_active')->default(true);
            $t->timestamps(6);
        });
    }
    public function down(): void { Schema::dropIfExists('asset_categories'); }
};
