<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('workflow_definitions', function (Blueprint $t) {
            $t->id();
            $t->string('code', 60);
            $t->string('name', 150);
            $t->string('module', 50);
            $t->unsignedInteger('version');
            $t->text('description')->nullable();
            $t->boolean('is_active')->default(true);
            $t->timestamps(6);
            $t->unique(['code', 'version']);
        });
    }
    public function down(): void { Schema::dropIfExists('workflow_definitions'); }
};
