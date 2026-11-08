<?php
namespace App\Modules\OfficialTravel\Models;
use App\Modules\Identity\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class OfficialTravelParticipant extends Model {
    protected $fillable = ['official_travel_request_id','employee_id','participant_role'];
    public function request(): BelongsTo { return $this->belongsTo(OfficialTravelRequest::class,'official_travel_request_id'); }
    public function employee(): BelongsTo { return $this->belongsTo(Employee::class); }
}