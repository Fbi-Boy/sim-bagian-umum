<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('document_versions', function (Blueprint $t) {
            $t->id();
            $t->foreignId('document_id')->constrained()->restrictOnDelete();
            $t->unsignedInteger('version_number');
            $t->string('disk', 40)->default('private');
            $t->string('path', 500);
            $t->string('original_filename', 255);
            $t->string('stored_filename', 255);
            $t->string('mime_type', 120);
            $t->unsignedBigInteger('file_size_bytes');
            $t->char('sha256', 64);
            $t->foreignId('uploaded_by_user_id')->constrained('users')->restrictOnDelete();
            $t->timestamp('uploaded_at', 6)->useCurrent();
            $t->boolean('is_current')->default(false);
            $t->timestamp('created_at', 6)->useCurrent();
            $t->unique(['document_id', 'version_number']);
            $t->index(['document_id', 'is_current']);
        });
    }
    public function down(): void { Schema::dropIfExists('document_versions'); }
};
