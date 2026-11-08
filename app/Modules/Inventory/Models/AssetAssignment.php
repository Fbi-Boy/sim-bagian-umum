<?php
namespace App\Modules\Inventory\Models;
use App\Models\User;
use App\Modules\Identity\Models\Employee;
use App\Modules\Organization\Models\OrganizationalUnit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class AssetAssignment extends Model {
    protected $fillable = ['asset_id','employee_id','organizational_unit_id','assigned_by_user_id','starts_at','ends_at','assignment_note'];
    protected $casts = ['starts_at'=>'datetime','ends_at'=>'datetime'];
    public function asset(): BelongsTo { return $this->belongsTo(Asset::class); }
    public function employee(): BelongsTo { return $this->belongsTo(Employee::class); }
    public function organizationalUnit(): BelongsTo { return $this->belongsTo(OrganizationalUnit::class); }
    public function assignedBy(): BelongsTo { return $this->belongsTo(User::class,'assigned_by_user_id'); }
}