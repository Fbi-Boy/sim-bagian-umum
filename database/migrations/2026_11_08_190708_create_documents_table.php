<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('documents', function (Blueprint $t) {
            $t->id();
            $t->char('public_id', 26)->unique();
            $t->string('title', 200);
            $t->text('description')->nullable();
            $t->foreignId('archive_classification_id')->nullable()
                ->constrained('archive_classifications')->nullOnDelete();
            $t->foreignId('owner_unit_id')->nullable()
                ->constrained('organizational_units')->nullOnDelete();
            $t->string('confidentiality', 25)->default('internal');
            $t->string('document_status', 25)->default('active');
            $t->foreignId('uploaded_by_user_id')->constrained('users')->restrictOnDelete();
            $t->timestamps(6);
        });
    }
    public function down(): void { Schema::dropIfExists('documents'); }
};
