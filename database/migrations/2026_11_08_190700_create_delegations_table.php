<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('delegations', function (Blueprint $t) {
            $t->id();
            $t->foreignId('delegator_user_id')->constrained('users')->restrictOnDelete();
            $t->foreignId('delegate_user_id')->constrained('users')->restrictOnDelete();
            $t->foreignId('permission_id')->constrained()->restrictOnDelete();
            $t->foreignId('scope_unit_id')->nullable()
                ->constrained('organizational_units')->nullOnDelete();
            $t->timestamp('starts_at', 6);
            $t->timestamp('ends_at', 6);
            $t->string('reference_number', 100)->nullable();
            $t->text('reason');
            $t->string('status', 20)->default('pending');
            $t->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $t->timestamps(6);
            $t->index(['delegate_user_id', 'status', 'starts_at', 'ends_at']);
        });
    }
    public function down(): void { Schema::dropIfExists('delegations'); }
};
