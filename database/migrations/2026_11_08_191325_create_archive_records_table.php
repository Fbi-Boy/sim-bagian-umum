<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('archive_records', function (Blueprint $t) {
            $t->id();
            $t->foreignId('document_id')->unique()->constrained()->restrictOnDelete();
            $t->string('archive_code', 80)->unique();
            $t->foreignId('archive_classification_id')
                ->constrained()->restrictOnDelete();
            $t->date('record_date')->nullable();
            $t->date('retention_start_date')->nullable();
            $t->date('retention_end_date')->nullable();
            $t->string('archive_status', 25)->default('active');
            $t->string('physical_location', 180)->nullable();
            $t->foreignId('registered_by_user_id')->constrained('users')->restrictOnDelete();
            $t->timestamps(6);

            $t->index(['archive_status', 'retention_end_date'], 'ar_status_ret_idx');
        });
    }
    public function down(): void { Schema::dropIfExists('archive_records'); }
};
