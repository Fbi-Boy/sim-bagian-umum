<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('archive_loan_items', function (Blueprint $t) {
            $t->id();
            $t->foreignId('archive_loan_id')->constrained()->restrictOnDelete();
            $t->foreignId('archive_record_id')->constrained()->restrictOnDelete();
            $t->string('condition_out', 30)->nullable();
            $t->string('condition_in', 30)->nullable();
            $t->timestamp('returned_at', 6)->nullable();
            $t->timestamps(6);

            $t->unique(['archive_loan_id', 'archive_record_id'], 'ali_loan_record_uniq');
        });
    }
    public function down(): void { Schema::dropIfExists('archive_loan_items'); }
};
