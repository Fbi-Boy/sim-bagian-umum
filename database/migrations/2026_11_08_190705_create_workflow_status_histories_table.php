<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('workflow_status_histories', function (Blueprint $t) {
            $t->id();
            $t->foreignId('workflow_instance_id')->constrained()->restrictOnDelete();
            $t->string('from_status', 30)->nullable();
            $t->string('to_status', 30);
            $t->foreignId('changed_by_user_id')->constrained('users')->restrictOnDelete();
            $t->text('reason')->nullable();
            $t->timestamp('created_at', 6)->useCurrent();
        });
    }
    public function down(): void { Schema::dropIfExists('workflow_status_histories'); }
};
