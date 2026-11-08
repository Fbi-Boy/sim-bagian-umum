<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('units_of_measure', function (Blueprint $t) {
            $t->id();
            $t->string('code', 20)->unique();
            $t->string('name', 60);
            $t->unsignedTinyInteger('decimal_places')->default(0);
            $t->boolean('is_active')->default(true);
            $t->timestamps(6);
        });
    }
    public function down(): void { Schema::dropIfExists('units_of_measure'); }
};
