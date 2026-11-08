<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('user_roles', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->restrictOnDelete();
            $t->foreignId('role_id')->constrained()->restrictOnDelete();
            $t->foreignId('scope_unit_id')->nullable()
                ->constrained('organizational_units')->nullOnDelete();
            $t->timestamp('valid_from', 6);
            $t->timestamp('valid_until', 6)->nullable();
            $t->foreignId('granted_by')->constrained('users')->restrictOnDelete();
            $t->string('grant_reason', 255)->nullable();
            $t->timestamp('revoked_at', 6)->nullable();
            $t->foreignId('revoked_by')->nullable()->constrained('users')->nullOnDelete();
            $t->timestamps(6);
            $t->index(['user_id', 'valid_from', 'valid_until']);
            $t->index(['role_id', 'scope_unit_id']);
        });
    }
    public function down(): void { Schema::dropIfExists('user_roles'); }
};
