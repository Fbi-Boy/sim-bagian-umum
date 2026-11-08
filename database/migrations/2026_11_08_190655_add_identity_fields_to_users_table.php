<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('users', function (Blueprint $t) {
            $t->foreignId('employee_id')->nullable()->unique()->after('id')
                ->constrained('employees')->nullOnDelete();
            $t->string('status', 20)->default('active')->after('password');
            $t->timestamp('last_login_at', 6)->nullable();
        });
    }
    public function down(): void {
        Schema::table('users', function (Blueprint $t) {
            $t->dropForeign(['employee_id']);
            $t->dropColumn(['employee_id', 'status', 'last_login_at']);
        });
    }
};
