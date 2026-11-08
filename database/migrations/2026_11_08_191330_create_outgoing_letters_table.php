<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('outgoing_letters', function (Blueprint $t) {
            $t->id();
            $t->char('public_id', 26)->unique();
            $t->unsignedSmallInteger('register_year');
            $t->unsignedInteger('agenda_sequence');
            $t->string('official_letter_number', 120)->nullable();
            $t->date('letter_date')->nullable();
            $t->string('subject', 250);
            $t->text('body_summary')->nullable();
            $t->foreignId('creating_unit_id')->constrained('organizational_units')->restrictOnDelete();
            $t->foreignId('created_by_user_id')->constrained('users')->restrictOnDelete();
            $t->foreignId('signed_by_user_id')->nullable()
                ->constrained('users')->nullOnDelete();
            $t->timestamp('sent_at', 6)->nullable();
            $t->string('status', 30)->default('draft');
            $t->timestamps(6);

            $t->unique(['register_year', 'agenda_sequence'], 'outl_year_agenda_uniq');
            $t->index(['status', 'letter_date'], 'outl_status_date_idx');
            $t->index('official_letter_number', 'outl_number_idx');
        });
    }
    public function down(): void { Schema::dropIfExists('outgoing_letters'); }
};
