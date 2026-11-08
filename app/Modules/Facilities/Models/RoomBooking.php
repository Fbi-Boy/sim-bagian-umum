<?php
namespace App\Modules\Facilities\Models;
use App\Models\User;
use App\Modules\Events\Models\Event;
use App\Modules\Facilities\Enums\RoomBookingStatus;
use App\Modules\Organization\Models\OrganizationalUnit;
use App\Modules\Workflow\Models\WorkflowInstance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class RoomBooking extends Model {
    protected $fillable = ['booking_number','room_id','event_id','requester_user_id','requester_unit_id','purpose','attendee_count','starts_at','ends_at','setup_notes','workflow_instance_id','status','checked_in_at','checked_out_at'];
    protected $casts = ['starts_at'=>'datetime','ends_at'=>'datetime','checked_in_at'=>'datetime','checked_out_at'=>'datetime','attendee_count'=>'integer','status'=>RoomBookingStatus::class];
    public function room(): BelongsTo { return $this->belongsTo(Room::class); }
    public function event(): BelongsTo { return $this->belongsTo(Event::class); }
    public function requester(): BelongsTo { return $this->belongsTo(User::class,'requester_user_id'); }
    public function requesterUnit(): BelongsTo { return $this->belongsTo(OrganizationalUnit::class,'requester_unit_id'); }
    public function workflow(): BelongsTo { return $this->belongsTo(WorkflowInstance::class,'workflow_instance_id'); }
}