<?php
namespace App\Modules\Vehicles\Models;
use App\Modules\Inventory\Models\Asset;
use App\Modules\Vehicles\Enums\VehicleStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Vehicle extends Model {
    protected $fillable = ['asset_id','vehicle_code','license_plate','make','model','manufacture_year','passenger_capacity','fuel_type','tax_valid_until','registration_valid_until','vehicle_status'];
    protected $casts = ['tax_valid_until'=>'date','registration_valid_until'=>'date','vehicle_status'=>VehicleStatus::class];
    public function asset(): BelongsTo { return $this->belongsTo(Asset::class); }
    public function assignments(): HasMany { return $this->hasMany(VehicleAssignment::class); }
}