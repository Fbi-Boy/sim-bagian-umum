<?php
namespace App\Modules\Correspondence\Models;
use App\Models\User;
use App\Modules\Correspondence\Enums\LetterStatus;
use App\Modules\Organization\Models\OrganizationalUnit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class OutgoingLetter extends Model {
    protected $fillable = ['public_id','register_year','agenda_sequence','official_letter_number','letter_date','subject','body_summary','creating_unit_id','created_by_user_id','signed_by_user_id','sent_at','status'];
    protected $casts = ['letter_date'=>'date','sent_at'=>'datetime','status'=>LetterStatus::class];
    public function creatingUnit(): BelongsTo { return $this->belongsTo(OrganizationalUnit::class,'creating_unit_id'); }
    public function creator(): BelongsTo { return $this->belongsTo(User::class,'created_by_user_id'); }
    public function signer(): BelongsTo { return $this->belongsTo(User::class,'signed_by_user_id'); }
    public function recipients(): HasMany { return $this->hasMany(OutgoingLetterRecipient::class); }
}