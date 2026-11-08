<?php
namespace App\Modules\Supplies\Models;
use App\Modules\Inventory\Models\Location;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class StockBalance extends Model {
    public $timestamps = false;
    protected $fillable = ['supply_item_id','location_id','quantity_on_hand','quantity_reserved','updated_at'];
    protected $casts = ['quantity_on_hand'=>'decimal:3','quantity_reserved'=>'decimal:3','updated_at'=>'datetime'];
    public function item(): BelongsTo { return $this->belongsTo(SupplyItem::class,'supply_item_id'); }
    public function location(): BelongsTo { return $this->belongsTo(Location::class); }
}