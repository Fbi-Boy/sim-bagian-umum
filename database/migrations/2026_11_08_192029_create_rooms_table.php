<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('rooms', function (Blueprint $t) {
            $t->id();
            $t->foreignId('location_id')->unique()
                ->constrained('locations')->restrictOnDelete();
            $t->string('room_code', 50)->unique();
            $t->unsignedSmallInteger('capacity');
            $t->string('room_type', 30)->default('meeting');
            $t->string('status', 20)->default('active');
            $t->text('usage_notes')->nullable();
            $t->timestamps(6);
        });
    }
    public function down(): void { Schema::dropIfExists('rooms'); }
};
