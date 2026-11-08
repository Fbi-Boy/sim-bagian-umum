<?php
namespace App\Modules\Maintenance\Models;
use App\Models\User;
use App\Modules\Maintenance\Enums\MaintenanceStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class MaintenanceUpdate extends Model {
    public $timestamps = false;
    protected $fillable = ['maintenance_ticket_id','updated_by_user_id','status','progress_note','created_at'];
    protected $casts = ['status'=>MaintenanceStatus::class,'created_at'=>'datetime'];
    public function ticket(): BelongsTo { return $this->belongsTo(MaintenanceTicket::class,'maintenance_ticket_id'); }
    public function updatedBy(): BelongsTo { return $this->belongsTo(User::class,'updated_by_user_id'); }
}