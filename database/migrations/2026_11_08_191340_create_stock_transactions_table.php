<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('stock_transactions', function (Blueprint $t) {
            $t->id();
            $t->string('transaction_number', 50)->unique();
            $t->string('transaction_type', 25);
            $t->foreignId('source_location_id')->nullable()
                ->constrained('locations')->nullOnDelete();
            $t->foreignId('destination_location_id')->nullable()
                ->constrained('locations')->nullOnDelete();
            $t->foreignId('stock_request_id')->nullable()
                ->constrained('stock_requests')->nullOnDelete();
            $t->foreignId('reversal_of_transaction_id')->nullable()->unique()
                ->constrained('stock_transactions')->nullOnDelete();
            $t->string('status', 20)->default('draft');
            $t->timestamp('transaction_at', 6);
            $t->text('note')->nullable();
            $t->foreignId('created_by_user_id')->constrained('users')->restrictOnDelete();
            $t->foreignId('posted_by_user_id')->nullable()
                ->constrained('users')->nullOnDelete();
            $t->timestamp('posted_at', 6)->nullable();
            $t->timestamps(6);

            $t->index(['transaction_type', 'transaction_at'], 'st_type_at_idx');
            $t->index(['status', 'transaction_at'], 'st_status_at_idx');
        });
    }
    public function down(): void { Schema::dropIfExists('stock_transactions'); }
};
