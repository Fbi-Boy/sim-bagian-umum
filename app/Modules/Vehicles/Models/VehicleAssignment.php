<?php
namespace App\Modules\Vehicles\Models;
use App\Models\User;
use App\Modules\Vehicles\Enums\VehicleAssignmentStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class VehicleAssignment extends Model {
    protected $fillable = ['vehicle_request_id','vehicle_id','driver_id','assigned_by_user_id','planned_start_at','planned_end_at','actual_start_at','actual_end_at','odometer_start','odometer_end','status'];
    protected $casts = ['planned_start_at'=>'datetime','planned_end_at'=>'datetime','actual_start_at'=>'datetime','actual_end_at'=>'datetime','odometer_start'=>'decimal:1','odometer_end'=>'decimal:1','status'=>VehicleAssignmentStatus::class];
    public function request(): BelongsTo { return $this->belongsTo(VehicleRequest::class,'vehicle_request_id'); }
    public function vehicle(): BelongsTo { return $this->belongsTo(Vehicle::class); }
    public function driver(): BelongsTo { return $this->belongsTo(Driver::class); }
    public function assignedBy(): BelongsTo { return $this->belongsTo(User::class,'assigned_by_user_id'); }
    public function logs(): HasMany { return $this->hasMany(VehicleUsageLog::class); }
}