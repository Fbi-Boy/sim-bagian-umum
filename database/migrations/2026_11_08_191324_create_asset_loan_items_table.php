<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('asset_loan_items', function (Blueprint $t) {
            $t->id();
            $t->foreignId('asset_loan_id')->constrained()->restrictOnDelete();
            $t->foreignId('asset_id')->constrained()->restrictOnDelete();
            $t->string('condition_out', 25)->nullable();
            $t->string('condition_in', 25)->nullable();
            $t->timestamp('issued_at', 6)->nullable();
            $t->timestamp('returned_at', 6)->nullable();
            $t->text('return_note')->nullable();
            $t->foreignId('received_by_user_id')->nullable()
                ->constrained('users')->nullOnDelete();
            $t->timestamps(6);

            $t->unique(['asset_loan_id', 'asset_id'], 'ali_loan_asset_uniq');
            $t->index(['asset_id', 'returned_at'], 'ali_asset_return_idx');
        });
    }
    public function down(): void { Schema::dropIfExists('asset_loan_items'); }
};
