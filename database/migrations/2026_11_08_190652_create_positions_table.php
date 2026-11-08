<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('positions', function (Blueprint $t) {
            $t->id();
            $t->string('code', 40)->unique();
            $t->string('name', 160);
            $t->string('position_type', 40);
            $t->text('description')->nullable();
            $t->boolean('is_active')->default(true);
            $t->timestamps(6);
        });
    }
    public function down(): void { Schema::dropIfExists('positions'); }
};
