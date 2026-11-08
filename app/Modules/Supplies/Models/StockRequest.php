<?php
namespace App\Modules\Supplies\Models;
use App\Models\User;
use App\Modules\Inventory\Models\Location;
use App\Modules\Organization\Models\OrganizationalUnit;
use App\Modules\Supplies\Enums\StockRequestStatus;
use App\Modules\Workflow\Models\WorkflowInstance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class StockRequest extends Model {
    protected $fillable = ['request_number','requester_user_id','requester_unit_id','destination_location_id','purpose','needed_at','workflow_instance_id','status'];
    protected $casts = ['needed_at'=>'datetime','status'=>StockRequestStatus::class];
    public function requester(): BelongsTo { return $this->belongsTo(User::class,'requester_user_id'); }
    public function requesterUnit(): BelongsTo { return $this->belongsTo(OrganizationalUnit::class,'requester_unit_id'); }
    public function destination(): BelongsTo { return $this->belongsTo(Location::class,'destination_location_id'); }
    public function workflow(): BelongsTo { return $this->belongsTo(WorkflowInstance::class,'workflow_instance_id'); }
    public function items(): HasMany { return $this->hasMany(StockRequestItem::class); }
}