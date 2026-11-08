<?php
namespace App\Modules\Inventory\Models;
use App\Models\User;
use App\Modules\Identity\Models\Employee;
use App\Modules\Inventory\Enums\AssetCondition;
use App\Modules\Inventory\Enums\AssetStatus;
use App\Modules\Organization\Models\OrganizationalUnit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Asset extends Model {
    protected $fillable = ['public_id','asset_code','official_bmd_code','asset_category_id','name','brand','model','serial_number','asset_scope','acquisition_date','acquisition_source','acquisition_value','condition','status','location_id','responsible_unit_id','custodian_employee_id','qr_code_value','notes','created_by_user_id'];
    protected $casts = ['acquisition_date'=>'date','acquisition_value'=>'decimal:2','condition'=>AssetCondition::class,'status'=>AssetStatus::class];
    public function category(): BelongsTo { return $this->belongsTo(AssetCategory::class,'asset_category_id'); }
    public function location(): BelongsTo { return $this->belongsTo(Location::class); }
    public function responsibleUnit(): BelongsTo { return $this->belongsTo(OrganizationalUnit::class,'responsible_unit_id'); }
    public function custodian(): BelongsTo { return $this->belongsTo(Employee::class,'custodian_employee_id'); }
    public function creator(): BelongsTo { return $this->belongsTo(User::class,'created_by_user_id'); }
    public function assignments(): HasMany { return $this->hasMany(AssetAssignment::class); }
    public function movements(): HasMany { return $this->hasMany(AssetMovement::class); }
    public function loanItems(): HasMany { return $this->hasMany(AssetLoanItem::class); }
}