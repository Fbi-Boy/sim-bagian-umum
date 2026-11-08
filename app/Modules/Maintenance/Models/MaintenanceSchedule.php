<?php
namespace App\Modules\Maintenance\Models;
use App\Models\User;
use App\Modules\Facilities\Models\Room;
use App\Modules\Inventory\Models\Asset;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class MaintenanceSchedule extends Model {
    protected $fillable = ['target_asset_id','target_room_id','title','description','frequency_type','interval_value','next_due_at','last_completed_at','assigned_to_user_id','is_active'];
    protected $casts = ['next_due_at'=>'datetime','last_completed_at'=>'datetime','interval_value'=>'integer','is_active'=>'boolean'];
    public function targetAsset(): BelongsTo { return $this->belongsTo(Asset::class,'target_asset_id'); }
    public function targetRoom(): BelongsTo { return $this->belongsTo(Room::class,'target_room_id'); }
    public function assignee(): BelongsTo { return $this->belongsTo(User::class,'assigned_to_user_id'); }
}