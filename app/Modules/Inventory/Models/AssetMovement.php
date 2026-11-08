<?php
namespace App\Modules\Inventory\Models;
use App\Models\User;
use App\Modules\Identity\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class AssetMovement extends Model {
    public $timestamps = false;
    protected $fillable = ['asset_id','from_location_id','to_location_id','from_employee_id','to_employee_id','movement_type','reason','moved_at','recorded_by_user_id','approved_by_user_id','created_at'];
    protected $casts = ['moved_at'=>'datetime','created_at'=>'datetime'];
    public function asset(): BelongsTo { return $this->belongsTo(Asset::class); }
    public function fromLocation(): BelongsTo { return $this->belongsTo(Location::class,'from_location_id'); }
    public function toLocation(): BelongsTo { return $this->belongsTo(Location::class,'to_location_id'); }
    public function fromEmployee(): BelongsTo { return $this->belongsTo(Employee::class,'from_employee_id'); }
    public function toEmployee(): BelongsTo { return $this->belongsTo(Employee::class,'to_employee_id'); }
    public function recordedBy(): BelongsTo { return $this->belongsTo(User::class,'recorded_by_user_id'); }
}