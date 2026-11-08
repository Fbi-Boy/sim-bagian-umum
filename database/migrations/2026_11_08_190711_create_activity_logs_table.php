<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('activity_logs', function (Blueprint $t) {
            $t->id();
            $t->foreignId('actor_user_id')->nullable()->constrained('users')->nullOnDelete();
            $t->string('action', 100);
            $t->string('subject_type', 80)->nullable();
            $t->unsignedBigInteger('subject_id')->nullable();
            $t->json('old_values')->nullable();
            $t->json('new_values')->nullable();
            $t->text('reason')->nullable();
            $t->string('ip_address', 45)->nullable();
            $t->string('user_agent', 500)->nullable();
            $t->char('request_id', 36)->nullable();
            $t->timestamp('created_at', 6)->useCurrent();
            $t->index(['actor_user_id', 'created_at']);
            $t->index(['subject_type', 'subject_id']);
            $t->index(['action', 'created_at']);
        });
    }
    public function down(): void { Schema::dropIfExists('activity_logs'); }
};
