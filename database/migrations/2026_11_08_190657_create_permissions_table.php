<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('permissions', function (Blueprint $t) {
            $t->id();
            $t->string('code', 100)->unique();
            $t->string('module', 50);
            $t->string('name', 120);
            $t->text('description')->nullable();
            $t->timestamps(6);
            $t->index('module');
        });
    }
    public function down(): void { Schema::dropIfExists('permissions'); }
};
