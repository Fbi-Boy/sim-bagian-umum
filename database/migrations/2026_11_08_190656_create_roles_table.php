<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('roles', function (Blueprint $t) {
            $t->id();
            $t->string('code', 60)->unique();
            $t->string('name', 100);
            $t->text('description')->nullable();
            $t->boolean('is_system')->default(false);
            $t->boolean('is_active')->default(true);
            $t->timestamps(6);
        });
    }
    public function down(): void { Schema::dropIfExists('roles'); }
};
