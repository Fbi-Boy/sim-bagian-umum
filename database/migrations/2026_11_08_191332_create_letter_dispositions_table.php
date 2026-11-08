<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('letter_dispositions', function (Blueprint $t) {
            $t->id();
            $t->foreignId('incoming_letter_id')->constrained()->restrictOnDelete();
            $t->foreignId('parent_disposition_id')->nullable()
                ->constrained('letter_dispositions')->nullOnDelete();
            $t->foreignId('from_user_id')->constrained('users')->restrictOnDelete();
            $t->foreignId('to_user_id')->nullable()->constrained('users')->nullOnDelete();
            $t->foreignId('to_unit_id')->nullable()
                ->constrained('organizational_units')->nullOnDelete();
            $t->text('instruction');
            $t->string('priority', 20)->default('normal');
            $t->timestamp('due_at', 6)->nullable();
            $t->string('status', 25)->default('assigned');
            $t->timestamps(6);

            $t->index(['incoming_letter_id', 'status'], 'ld_letter_status_idx');
            $t->index(['to_user_id', 'status'], 'ld_user_status_idx');
            $t->index(['to_unit_id', 'status'], 'ld_unit_status_idx');
        });

        // CHECK dihapus: kolom to_user_id & to_unit_id punya FK ON DELETE SET NULL.
        // MySQL larang CHECK menyentuh kolom FK dengan referential action.
        // Validasi "minimal satu penerima terisi" WAJIB dilakukan di FormRequest + Action.
    }

    public function down(): void {
        Schema::dropIfExists('letter_dispositions');
    }
};
