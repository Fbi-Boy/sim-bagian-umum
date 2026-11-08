<?php
namespace App\Modules\Correspondence\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class OutgoingLetterRecipient extends Model {
    protected $fillable = ['outgoing_letter_id','recipient_name','recipient_organization','recipient_address','recipient_type','delivery_channel','delivery_status','delivered_at'];
    protected $casts = ['delivered_at'=>'datetime'];
    public function letter(): BelongsTo { return $this->belongsTo(OutgoingLetter::class,'outgoing_letter_id'); }
}