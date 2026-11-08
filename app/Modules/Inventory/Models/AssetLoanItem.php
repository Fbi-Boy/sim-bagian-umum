<?php
namespace App\Modules\Inventory\Models;
use App\Models\User;
use App\Modules\Inventory\Enums\AssetCondition;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class AssetLoanItem extends Model {
    protected $fillable = ['asset_loan_id','asset_id','condition_out','condition_in','issued_at','returned_at','return_note','received_by_user_id'];
    protected $casts = ['condition_out'=>AssetCondition::class,'condition_in'=>AssetCondition::class,'issued_at'=>'datetime','returned_at'=>'datetime'];
    public function loan(): BelongsTo { return $this->belongsTo(AssetLoan::class,'asset_loan_id'); }
    public function asset(): BelongsTo { return $this->belongsTo(Asset::class); }
    public function receivedBy(): BelongsTo { return $this->belongsTo(User::class,'received_by_user_id'); }
}