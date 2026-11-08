<?php
namespace App\Modules\Correspondence\Models;
use App\Models\User;
use App\Modules\Correspondence\Enums\DispositionStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class LetterDispositionUpdate extends Model {
    public $timestamps = false;
    protected $fillable = ['letter_disposition_id','updated_by_user_id','status','progress_note','created_at'];
    protected $casts = ['status'=>DispositionStatus::class,'created_at'=>'datetime'];
    public function disposition(): BelongsTo { return $this->belongsTo(LetterDisposition::class,'letter_disposition_id'); }
    public function updatedBy(): BelongsTo { return $this->belongsTo(User::class,'updated_by_user_id'); }
}