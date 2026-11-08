<?php
namespace App\Modules\Events\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class EventAgenda extends Model {
    protected $fillable = ['event_id','sequence_number','agenda_title','starts_at','ends_at','person_in_charge','notes'];
    protected $casts = ['starts_at'=>'datetime','ends_at'=>'datetime','sequence_number'=>'integer'];
    public function event(): BelongsTo { return $this->belongsTo(Event::class); }
}