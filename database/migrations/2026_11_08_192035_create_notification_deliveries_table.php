<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('notification_deliveries', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $t->string('notification_key', 100);
            $t->string('channel', 20);
            $t->string('reference_type', 80)->nullable();
            $t->unsignedBigInteger('reference_id')->nullable();
            $t->string('status', 20)->default('queued');
            $t->string('provider_message_id', 150)->nullable();
            $t->unsignedSmallInteger('attempt_count')->default(0);
            $t->string('last_error_code', 80)->nullable();
            $t->timestamp('sent_at', 6)->nullable();
            $t->timestamps(6);

            $t->index(['status', 'created_at'], 'nd_status_created_idx');
            $t->index(['user_id', 'created_at'], 'nd_user_created_idx');
            $t->index(['reference_type', 'reference_id'], 'nd_ref_idx');
        });
    }
    public function down(): void { Schema::dropIfExists('notification_deliveries'); }
};
