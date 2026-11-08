<?php
namespace App\Modules\Supplies\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class StockTransactionItem extends Model {
    protected $fillable = ['stock_transaction_id','supply_item_id','quantity','unit_cost','note'];
    protected $casts = ['quantity'=>'decimal:3','unit_cost'=>'decimal:2'];
    public function transaction(): BelongsTo { return $this->belongsTo(StockTransaction::class,'stock_transaction_id'); }
    public function item(): BelongsTo { return $this->belongsTo(SupplyItem::class,'supply_item_id'); }
}