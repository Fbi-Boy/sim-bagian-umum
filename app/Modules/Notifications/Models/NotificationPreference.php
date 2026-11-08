<?php
namespace App\Modules\Notifications\Models;
use App\Models\User;
use App\Modules\Notifications\Enums\NotificationChannel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class NotificationPreference extends Model {
    protected $fillable = ['user_id','channel','notification_key','is_enabled'];
    protected $casts = ['channel'=>NotificationChannel::class,'is_enabled'=>'boolean'];
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
}