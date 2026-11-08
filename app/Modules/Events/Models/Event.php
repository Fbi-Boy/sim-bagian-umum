<?php
namespace App\Modules\Events\Models;
use App\Models\User;
use App\Modules\Events\Enums\EventStatus;
use App\Modules\Inventory\Models\Location;
use App\Modules\Organization\Models\OrganizationalUnit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Event extends Model {
    protected $fillable = ['public_id','event_number','title','event_type','organizing_unit_id','coordinator_user_id','starts_at','ends_at','location_id','location_text','description','status','created_by_user_id'];
    protected $casts = ['starts_at'=>'datetime','ends_at'=>'datetime','status'=>EventStatus::class];
    public function organizingUnit(): BelongsTo { return $this->belongsTo(OrganizationalUnit::class,'organizing_unit_id'); }
    public function coordinator(): BelongsTo { return $this->belongsTo(User::class,'coordinator_user_id'); }
    public function location(): BelongsTo { return $this->belongsTo(Location::class); }
    public function creator(): BelongsTo { return $this->belongsTo(User::class,'created_by_user_id'); }
    public function agendas(): HasMany { return $this->hasMany(EventAgenda::class); }
    public function tasks(): HasMany { return $this->hasMany(EventTask::class); }
    public function guests(): HasMany { return $this->hasMany(EventGuest::class); }
    public function roomBookings(): HasMany { return $this->hasMany(\App\Modules\Facilities\Models\RoomBooking::class); }
}