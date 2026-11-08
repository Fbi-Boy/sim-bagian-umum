<?php
namespace App\Modules\Vehicles\Models;
use App\Modules\Identity\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Driver extends Model {
    protected $fillable = ['employee_id','driver_name','license_number','license_class','license_expires_on','phone','status'];
    protected $casts = ['license_expires_on'=>'date'];
    public function employee(): BelongsTo { return $this->belongsTo(Employee::class); }
    public function assignments(): HasMany { return $this->hasMany(VehicleAssignment::class); }
}