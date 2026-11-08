<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('official_travel_participants', function (Blueprint $t) {
            $t->id();
            $t->foreignId('official_travel_request_id')
                ->constrained('official_travel_requests')->restrictOnDelete();
            $t->foreignId('employee_id')->constrained('employees')->restrictOnDelete();
            $t->string('participant_role', 30)->default('participant');
            $t->timestamps(6);

            $t->unique(
                ['official_travel_request_id', 'employee_id'],
                'otp_req_emp_uniq'
            );
        });
    }
    public function down(): void { Schema::dropIfExists('official_travel_participants'); }
};
