<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('report_exports', function (Blueprint $t) {
            $t->id();
            $t->foreignId('requested_by_user_id')
                ->constrained('users')->restrictOnDelete();
            $t->string('report_key', 80);
            $t->json('filters')->nullable();
            $t->string('format', 10);
            $t->string('status', 20)->default('queued');
            $t->string('disk', 40)->nullable();
            $t->string('path', 500)->nullable();
            $t->timestamp('expires_at', 6)->nullable();
            $t->timestamp('completed_at', 6)->nullable();
            $t->timestamps(6);

            $t->index(['requested_by_user_id', 'created_at'], 're_user_created_idx');
            $t->index(['status', 'created_at'], 're_status_created_idx');
        });
    }
    public function down(): void { Schema::dropIfExists('report_exports'); }
};
