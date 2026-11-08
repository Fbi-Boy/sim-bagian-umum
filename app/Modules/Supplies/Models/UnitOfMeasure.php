<?php
namespace App\Modules\Supplies\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class UnitOfMeasure extends Model {
    protected $fillable = ['code','name','decimal_places','is_active'];
    protected $casts = ['is_active'=>'boolean','decimal_places'=>'integer'];
    public function supplyItems(): HasMany { return $this->hasMany(SupplyItem::class); }
}