<?php
namespace App\Modules\Inventory\Models;
use App\Models\User;
use App\Modules\Inventory\Enums\AssetLoanStatus;
use App\Modules\Organization\Models\OrganizationalUnit;
use App\Modules\Workflow\Models\WorkflowInstance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class AssetLoan extends Model {
    protected $fillable = ['loan_number','requester_user_id','requester_unit_id','purpose','starts_at','expected_return_at','workflow_instance_id','status','handed_over_by_user_id','handed_over_at'];
    protected $casts = ['starts_at'=>'datetime','expected_return_at'=>'datetime','handed_over_at'=>'datetime','status'=>AssetLoanStatus::class];
    public function requester(): BelongsTo { return $this->belongsTo(User::class,'requester_user_id'); }
    public function requesterUnit(): BelongsTo { return $this->belongsTo(OrganizationalUnit::class,'requester_unit_id'); }
    public function workflow(): BelongsTo { return $this->belongsTo(WorkflowInstance::class,'workflow_instance_id'); }
    public function handedOverBy(): BelongsTo { return $this->belongsTo(User::class,'handed_over_by_user_id'); }
    public function items(): HasMany { return $this->hasMany(AssetLoanItem::class); }
}