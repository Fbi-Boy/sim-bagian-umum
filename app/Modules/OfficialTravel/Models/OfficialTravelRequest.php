<?php
namespace App\Modules\OfficialTravel\Models;
use App\Models\User;
use App\Modules\Events\Models\Event;
use App\Modules\Identity\Models\Employee;
use App\Modules\OfficialTravel\Enums\TravelRequestStatus;
use App\Modules\Organization\Models\OrganizationalUnit;
use App\Modules\Workflow\Models\WorkflowInstance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class OfficialTravelRequest extends Model {
    protected $fillable = ['request_number','requester_employee_id','requester_unit_id','event_id','purpose','destination','departure_at','return_at','transport_mode','workflow_instance_id','status','created_by_user_id'];
    protected $casts = ['departure_at'=>'datetime','return_at'=>'datetime','status'=>TravelRequestStatus::class];
    public function requesterEmployee(): BelongsTo { return $this->belongsTo(Employee::class,'requester_employee_id'); }
    public function requesterUnit(): BelongsTo { return $this->belongsTo(OrganizationalUnit::class,'requester_unit_id'); }
    public function event(): BelongsTo { return $this->belongsTo(Event::class); }
    public function workflow(): BelongsTo { return $this->belongsTo(WorkflowInstance::class,'workflow_instance_id'); }
    public function creator(): BelongsTo { return $this->belongsTo(User::class,'created_by_user_id'); }
    public function participants(): HasMany { return $this->hasMany(OfficialTravelParticipant::class); }
}