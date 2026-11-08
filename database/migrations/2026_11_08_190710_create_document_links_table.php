<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('document_links', function (Blueprint $t) {
            $t->id();
            $t->foreignId('document_id')->constrained()->restrictOnDelete();
            $t->string('documentable_type', 80);
            $t->unsignedBigInteger('documentable_id');
            $t->string('link_purpose', 40);
            $t->foreignId('created_by_user_id')->constrained('users')->restrictOnDelete();
            $t->timestamp('created_at', 6)->useCurrent();
            $t->index(['documentable_type', 'documentable_id'], 'doc_links_morph_idx');
            $t->unique(
                ['document_id', 'documentable_type', 'documentable_id', 'link_purpose'],
                'doc_links_unique'
            );
        });
    }
    public function down(): void { Schema::dropIfExists('document_links'); }
};
