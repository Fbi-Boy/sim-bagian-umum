<?php
namespace App\Modules\Vehicles\Models;
use App\Models\User;
use App\Modules\Events\Models\Event;
use App\Modules\OfficialTravel\Models\OfficialTravelRequest;
use App\Modules\Organization\Models\OrganizationalUnit;
use App\Modules\Vehicles\Enums\VehicleRequestStatus;
use App\Modules\Workflow\Models\WorkflowInstance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class VehicleRequest extends Model {
    protected $fillable = ['request_number','requester_user_id','requester_unit_id','event_id','official_travel_request_id','purpose','destination','pickup_location','starts_at','ends_at','passenger_count','workflow_instance_id','status'];
    protected $casts = ['starts_at'=>'datetime','ends_at'=>'datetime','passenger_count'=>'integer','status'=>VehicleRequestStatus::class];
    public function requester(): BelongsTo { return $this->belongsTo(User::class,'requester_user_id'); }
    public function requesterUnit(): BelongsTo { return $this->belongsTo(OrganizationalUnit::class,'requester_unit_id'); }
    public function event(): BelongsTo { return $this->belongsTo(Event::class); }
    public function officialTravel(): BelongsTo { return $this->belongsTo(OfficialTravelRequest::class,'official_travel_request_id'); }
    public function workflow(): BelongsTo { return $this->belongsTo(WorkflowInstance::class,'workflow_instance_id'); }
    public function assignments(): HasMany { return $this->hasMany(VehicleAssignment::class); }
}