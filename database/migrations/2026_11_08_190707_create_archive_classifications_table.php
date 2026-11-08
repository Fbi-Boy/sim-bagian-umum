<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('archive_classifications', function (Blueprint $t) {
            $t->id();
            $t->foreignId('parent_id')->nullable()
                ->constrained('archive_classifications')->nullOnDelete();
            $t->string('code', 60)->unique();
            $t->string('name', 180);
            $t->text('description')->nullable();
            $t->unsignedSmallInteger('retention_active_months')->nullable();
            $t->unsignedSmallInteger('retention_inactive_months')->nullable();
            $t->string('final_disposition', 30)->nullable();
            $t->boolean('is_active')->default(true);
            $t->timestamps(6);
        });
    }
    public function down(): void { Schema::dropIfExists('archive_classifications'); }
};
