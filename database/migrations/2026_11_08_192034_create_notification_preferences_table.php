<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('notification_preferences', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $t->string('channel', 20);
            $t->string('notification_key', 100);
            $t->boolean('is_enabled')->default(true);
            $t->timestamps(6);

            $t->unique(['user_id', 'channel', 'notification_key'], 'np_user_chan_key_uniq');
        });
    }
    public function down(): void { Schema::dropIfExists('notification_preferences'); }
};
