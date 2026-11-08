<?php
namespace App\Modules\Maintenance\Models;
use App\Models\User;
use App\Modules\Facilities\Models\Room;
use App\Modules\Inventory\Models\Asset;
use App\Modules\Maintenance\Enums\MaintenancePriority;
use App\Modules\Maintenance\Enums\MaintenanceStatus;
use App\Modules\Organization\Models\OrganizationalUnit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class MaintenanceTicket extends Model {
    protected $fillable = ['ticket_number','target_asset_id','target_room_id','reported_by_user_id','organizational_unit_id','category','priority','title','description','status','assigned_to_user_id','verified_by_user_id','completed_at'];
    protected $casts = ['priority'=>MaintenancePriority::class,'status'=>MaintenanceStatus::class,'completed_at'=>'datetime'];
    public function targetAsset(): BelongsTo { return $this->belongsTo(Asset::class,'target_asset_id'); }
    public function targetRoom(): BelongsTo { return $this->belongsTo(Room::class,'target_room_id'); }
    public function reportedBy(): BelongsTo { return $this->belongsTo(User::class,'reported_by_user_id'); }
    public function organizationalUnit(): BelongsTo { return $this->belongsTo(OrganizationalUnit::class); }
    public function assignee(): BelongsTo { return $this->belongsTo(User::class,'assigned_to_user_id'); }
    public function verifier(): BelongsTo { return $this->belongsTo(User::class,'verified_by_user_id'); }
    public function updates(): HasMany { return $this->hasMany(MaintenanceUpdate::class); }
}