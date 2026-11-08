<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('archive_loans', function (Blueprint $t) {
            $t->id();
            $t->string('loan_number', 50)->unique();
            $t->foreignId('borrower_user_id')->constrained('users')->restrictOnDelete();
            $t->foreignId('borrower_unit_id')->constrained('organizational_units')->restrictOnDelete();
            $t->text('purpose');
            $t->timestamp('requested_at', 6);
            $t->timestamp('due_at', 6);
            $t->foreignId('approved_by_user_id')->nullable()
                ->constrained('users')->nullOnDelete();
            $t->string('status', 25)->default('submitted');
            $t->timestamp('issued_at', 6)->nullable();
            $t->timestamp('returned_at', 6)->nullable();
            $t->timestamps(6);

            $t->index(['status', 'due_at'], 'arcl_status_due_idx');
        });
    }
    public function down(): void { Schema::dropIfExists('archive_loans'); }
};
