<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('event_guests', function (Blueprint $t) {
            $t->id();
            $t->foreignId('event_id')->constrained('events')->restrictOnDelete();
            $t->string('guest_name', 180);
            $t->string('organization_name', 180)->nullable();
            $t->string('guest_category', 40)->nullable();
            $t->string('attendance_status', 20)->default('invited');
            $t->text('protocol_notes')->nullable();
            $t->timestamps(6);

            $t->index(['event_id', 'attendance_status'], 'eg_event_status_idx');
        });
    }
    public function down(): void { Schema::dropIfExists('event_guests'); }
};
