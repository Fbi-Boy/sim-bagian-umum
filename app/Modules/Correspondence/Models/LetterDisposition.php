<?php
namespace App\Modules\Correspondence\Models;
use App\Models\User;
use App\Modules\Correspondence\Enums\DispositionStatus;
use App\Modules\Organization\Models\OrganizationalUnit;
use App\Modules\Workflow\Enums\Priority;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class LetterDisposition extends Model {
    protected $fillable = ['incoming_letter_id','parent_disposition_id','from_user_id','to_user_id','to_unit_id','instruction','priority','due_at','status'];
    protected $casts = ['due_at'=>'datetime','priority'=>Priority::class,'status'=>DispositionStatus::class];
    public function letter(): BelongsTo { return $this->belongsTo(IncomingLetter::class,'incoming_letter_id'); }
    public function parent(): BelongsTo { return $this->belongsTo(self::class,'parent_disposition_id'); }
    public function fromUser(): BelongsTo { return $this->belongsTo(User::class,'from_user_id'); }
    public function toUser(): BelongsTo { return $this->belongsTo(User::class,'to_user_id'); }
    public function toUnit(): BelongsTo { return $this->belongsTo(OrganizationalUnit::class,'to_unit_id'); }
    public function updates(): HasMany { return $this->hasMany(LetterDispositionUpdate::class); }
}