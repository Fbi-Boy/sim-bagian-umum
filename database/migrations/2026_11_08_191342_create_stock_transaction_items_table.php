<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('stock_transaction_items', function (Blueprint $t) {
            $t->id();
            $t->foreignId('stock_transaction_id')->constrained()->restrictOnDelete();
            $t->foreignId('supply_item_id')->constrained()->restrictOnDelete();
            $t->decimal('quantity', 18, 3);
            $t->decimal('unit_cost', 18, 2)->nullable();
            $t->string('note', 255)->nullable();
            $t->timestamps(6);

            // Nama pendek: default 71 chars (melebihi limit MySQL)
            $t->index(['supply_item_id', 'stock_transaction_id'], 'sti_item_txn_idx');
        });

        DB::statement('ALTER TABLE stock_transaction_items ADD CONSTRAINT chk_sti_quantity CHECK (quantity > 0)');
    }
    public function down(): void { Schema::dropIfExists('stock_transaction_items'); }
};
