<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('event_agendas', function (Blueprint $t) {
            $t->id();
            $t->foreignId('event_id')->constrained('events')->restrictOnDelete();
            $t->unsignedSmallInteger('sequence_number');
            $t->string('agenda_title', 180);
            $t->timestamp('starts_at', 6);
            $t->timestamp('ends_at', 6);
            $t->string('person_in_charge', 180)->nullable();
            $t->text('notes')->nullable();
            $t->timestamps(6);

            $t->unique(['event_id', 'sequence_number'], 'ea_event_seq_uniq');
        });

        DB::statement('ALTER TABLE event_agendas ADD CONSTRAINT chk_ea_period CHECK (ends_at > starts_at)');
    }
    public function down(): void { Schema::dropIfExists('event_agendas'); }
};
