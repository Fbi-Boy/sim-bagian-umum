<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('outgoing_letter_recipients', function (Blueprint $t) {
            $t->id();
            $t->foreignId('outgoing_letter_id')->constrained()->restrictOnDelete();
            $t->string('recipient_name', 180);
            $t->string('recipient_organization', 180)->nullable();
            $t->text('recipient_address')->nullable();
            $t->string('recipient_type', 25)->default('primary');
            $t->string('delivery_channel', 30)->nullable();
            $t->string('delivery_status', 25)->nullable();
            $t->timestamp('delivered_at', 6)->nullable();
            $t->timestamps(6);

            // Nama pendek: default akan 70+ karakter (melebihi limit MySQL)
            $t->index(['outgoing_letter_id', 'recipient_type'], 'olr_letter_type_idx');
        });
    }
    public function down(): void { Schema::dropIfExists('outgoing_letter_recipients'); }
};
