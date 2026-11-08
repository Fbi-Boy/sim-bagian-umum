<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('maintenance_updates', function (Blueprint $t) {
            $t->id();
            $t->foreignId('maintenance_ticket_id')
                ->constrained('maintenance_tickets')->restrictOnDelete();
            $t->foreignId('updated_by_user_id')
                ->constrained('users')->restrictOnDelete();
            $t->string('status', 25);
            $t->text('progress_note');
            $t->timestamp('created_at', 6)->useCurrent();
        });
    }
    public function down(): void { Schema::dropIfExists('maintenance_updates'); }
};
