<?php
namespace App\Modules\Reporting\Models;
use App\Models\User;
use App\Modules\Reporting\Enums\ReportFormat;
use App\Modules\Reporting\Enums\ReportStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class ReportExport extends Model {
    protected $fillable = ['requested_by_user_id','report_key','filters','format','status','disk','path','expires_at','completed_at'];
    protected $casts = ['filters'=>'array','format'=>ReportFormat::class,'status'=>ReportStatus::class,'expires_at'=>'datetime','completed_at'=>'datetime'];
    public function requester(): BelongsTo { return $this->belongsTo(User::class,'requested_by_user_id'); }
}