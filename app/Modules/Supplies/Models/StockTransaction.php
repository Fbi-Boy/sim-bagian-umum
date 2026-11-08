<?php
namespace App\Modules\Supplies\Models;
use App\Models\User;
use App\Modules\Inventory\Models\Location;
use App\Modules\Supplies\Enums\StockTransactionStatus;
use App\Modules\Supplies\Enums\StockTransactionType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class StockTransaction extends Model {
    protected $fillable = ['transaction_number','transaction_type','source_location_id','destination_location_id','stock_request_id','reversal_of_transaction_id','status','transaction_at','note','created_by_user_id','posted_by_user_id','posted_at'];
    protected $casts = ['transaction_type'=>StockTransactionType::class,'status'=>StockTransactionStatus::class,'transaction_at'=>'datetime','posted_at'=>'datetime'];
    public function sourceLocation(): BelongsTo { return $this->belongsTo(Location::class,'source_location_id'); }
    public function destinationLocation(): BelongsTo { return $this->belongsTo(Location::class,'destination_location_id'); }
    public function stockRequest(): BelongsTo { return $this->belongsTo(StockRequest::class); }
    public function reversalOf(): BelongsTo { return $this->belongsTo(self::class,'reversal_of_transaction_id'); }
    public function creator(): BelongsTo { return $this->belongsTo(User::class,'created_by_user_id'); }
    public function poster(): BelongsTo { return $this->belongsTo(User::class,'posted_by_user_id'); }
    public function items(): HasMany { return $this->hasMany(StockTransactionItem::class); }
}