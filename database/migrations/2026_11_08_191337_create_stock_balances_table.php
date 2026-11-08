<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('stock_balances', function (Blueprint $t) {
            $t->id();
            $t->foreignId('supply_item_id')->constrained()->restrictOnDelete();
            $t->foreignId('location_id')->constrained()->restrictOnDelete();
            $t->decimal('quantity_on_hand', 18, 3)->default(0);
            $t->decimal('quantity_reserved', 18, 3)->default(0);
            $t->timestamp('updated_at', 6)->useCurrent()->useCurrentOnUpdate();

            $t->unique(['supply_item_id', 'location_id'], 'sb_item_loc_uniq');
        });

        // Cegah saldo negatif (MySQL 8.0.16+)
        DB::statement('ALTER TABLE stock_balances ADD CONSTRAINT chk_sb_nonneg CHECK (quantity_on_hand >= 0 AND quantity_reserved >= 0 AND quantity_reserved <= quantity_on_hand)');
    }
    public function down(): void { Schema::dropIfExists('stock_balances'); }
};
