<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('stock_request_items', function (Blueprint $t) {
            $t->id();
            $t->foreignId('stock_request_id')->constrained()->restrictOnDelete();
            $t->foreignId('supply_item_id')->constrained()->restrictOnDelete();
            $t->decimal('requested_quantity', 18, 3);
            $t->decimal('approved_quantity', 18, 3)->nullable();
            $t->decimal('issued_quantity', 18, 3)->default(0);
            $t->string('note', 255)->nullable();
            $t->timestamps(6);

            $t->unique(['stock_request_id', 'supply_item_id'], 'sri_req_item_uniq');
        });

        DB::statement('ALTER TABLE stock_request_items ADD CONSTRAINT chk_sri_quantities CHECK (requested_quantity > 0 AND (approved_quantity IS NULL OR approved_quantity >= 0) AND issued_quantity >= 0)');
    }
    public function down(): void { Schema::dropIfExists('stock_request_items'); }
};
