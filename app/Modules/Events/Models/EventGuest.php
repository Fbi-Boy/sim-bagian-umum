<?php
namespace App\Modules\Events\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class EventGuest extends Model {
    protected $fillable = ['event_id','guest_name','organization_name','guest_category','attendance_status','protocol_notes'];
    public function event(): BelongsTo { return $this->belongsTo(Event::class); }
}