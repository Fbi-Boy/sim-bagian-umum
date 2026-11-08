<?php
namespace App\Modules\Notifications\Models;
use App\Models\User;
use App\Modules\Notifications\Enums\DeliveryStatus;
use App\Modules\Notifications\Enums\NotificationChannel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class NotificationDelivery extends Model {
    protected $fillable = ['user_id','notification_key','channel','reference_type','reference_id','status','provider_message_id','attempt_count','last_error_code','sent_at'];
    protected $casts = ['channel'=>NotificationChannel::class,'status'=>DeliveryStatus::class,'attempt_count'=>'integer','sent_at'=>'datetime'];
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
}