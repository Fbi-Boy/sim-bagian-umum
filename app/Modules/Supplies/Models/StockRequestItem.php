<?php
namespace App\Modules\Supplies\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class StockRequestItem extends Model {
    protected $fillable = ['stock_request_id','supply_item_id','requested_quantity','approved_quantity','issued_quantity','note'];
    protected $casts = ['requested_quantity'=>'decimal:3','approved_quantity'=>'decimal:3','issued_quantity'=>'decimal:3'];
    public function request(): BelongsTo { return $this->belongsTo(StockRequest::class,'stock_request_id'); }
    public function item(): BelongsTo { return $this->belongsTo(SupplyItem::class,'supply_item_id'); }
}