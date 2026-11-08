<?php
namespace App\Modules\Correspondence\Models;
use App\Models\User;
use App\Modules\Archives\Enums\DocumentConfidentiality;
use App\Modules\Archives\Models\ArchiveClassification;
use App\Modules\Correspondence\Enums\LetterStatus;
use App\Modules\Organization\Models\OrganizationalUnit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class IncomingLetter extends Model {
    protected $fillable = ['public_id','register_year','agenda_sequence','external_letter_number','letter_date','received_at','sender_name','sender_organization','subject','summary','classification_id','confidentiality','urgency','received_channel','recipient_unit_id','registered_by_user_id','status'];
    protected $casts = ['letter_date'=>'date','received_at'=>'datetime','confidentiality'=>DocumentConfidentiality::class,'status'=>LetterStatus::class];
    public function classification(): BelongsTo { return $this->belongsTo(ArchiveClassification::class,'classification_id'); }
    public function recipientUnit(): BelongsTo { return $this->belongsTo(OrganizationalUnit::class,'recipient_unit_id'); }
    public function registeredBy(): BelongsTo { return $this->belongsTo(User::class,'registered_by_user_id'); }
    public function dispositions(): HasMany { return $this->hasMany(LetterDisposition::class); }
}