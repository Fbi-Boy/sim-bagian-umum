<?php
namespace App\Modules\Supplies\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class SupplyItem extends Model {
    protected $fillable = ['sku','supply_category_id','unit_of_measure_id','name','description','minimum_stock','is_active'];
    protected $casts = ['minimum_stock'=>'decimal:3','is_active'=>'boolean'];
    public function category(): BelongsTo { return $this->belongsTo(SupplyCategory::class,'supply_category_id'); }
    public function unitOfMeasure(): BelongsTo { return $this->belongsTo(UnitOfMeasure::class); }
    public function balances(): HasMany { return $this->hasMany(StockBalance::class); }
    public function requestItems(): HasMany { return $this->hasMany(StockRequestItem::class); }
    public function transactionItems(): HasMany { return $this->hasMany(StockTransactionItem::class); }
}