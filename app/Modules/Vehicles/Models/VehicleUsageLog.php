<?php
namespace App\Modules\Vehicles\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class VehicleUsageLog extends Model {
    public $timestamps = false;
    protected $fillable = ['vehicle_assignment_id','event_type','happened_at','odometer','note','recorded_by_user_id','created_at'];
    protected $casts = ['happened_at'=>'datetime','odometer'=>'decimal:1','created_at'=>'datetime'];
    public function assignment(): BelongsTo { return $this->belongsTo(VehicleAssignment::class,'vehicle_assignment_id'); }
    public function recordedBy(): BelongsTo { return $this->belongsTo(User::class,'recorded_by_user_id'); }
}