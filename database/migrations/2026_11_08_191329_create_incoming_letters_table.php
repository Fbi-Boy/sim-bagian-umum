<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('incoming_letters', function (Blueprint $t) {
            $t->id();
            $t->char('public_id', 26)->unique();
            $t->unsignedSmallInteger('register_year');
            $t->unsignedInteger('agenda_sequence');
            $t->string('external_letter_number', 120)->nullable();
            $t->date('letter_date')->nullable();
            $t->timestamp('received_at', 6);
            $t->string('sender_name', 180);
            $t->string('sender_organization', 180)->nullable();
            $t->string('subject', 250);
            $t->text('summary')->nullable();
            $t->foreignId('classification_id')->nullable()
                ->constrained('archive_classifications')->nullOnDelete();
            $t->string('confidentiality', 25)->default('internal');
            $t->string('urgency', 20)->default('normal');
            $t->string('received_channel', 30)->default('physical');
            $t->foreignId('recipient_unit_id')->nullable()
                ->constrained('organizational_units')->nullOnDelete();
            $t->foreignId('registered_by_user_id')->constrained('users')->restrictOnDelete();
            $t->string('status', 30)->default('registered');
            $t->timestamps(6);

            $t->unique(['register_year', 'agenda_sequence'], 'inl_year_agenda_uniq');
            $t->index(['status', 'received_at'], 'inl_status_recv_idx');
            $t->index(['recipient_unit_id', 'status'], 'inl_unit_status_idx');
        });
    }
    public function down(): void { Schema::dropIfExists('incoming_letters'); }
};
