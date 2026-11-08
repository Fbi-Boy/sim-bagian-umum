<?php
namespace App\Modules\Events\Models;
use App\Models\User;
use App\Modules\Organization\Models\OrganizationalUnit;
use App\Modules\Workflow\Enums\Priority;
use App\Modules\Workflow\Enums\WorkTaskStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class EventTask extends Model {
    protected $fillable = ['event_id','task_title','description','responsible_unit_id','assigned_to_user_id','due_at','priority','status','completed_at','created_by_user_id'];
    protected $casts = ['due_at'=>'datetime','completed_at'=>'datetime','priority'=>Priority::class,'status'=>WorkTaskStatus::class];
    public function event(): BelongsTo { return $this->belongsTo(Event::class); }
    public function responsibleUnit(): BelongsTo { return $this->belongsTo(OrganizationalUnit::class,'responsible_unit_id'); }
    public function assignee(): BelongsTo { return $this->belongsTo(User::class,'assigned_to_user_id'); }
    public function creator(): BelongsTo { return $this->belongsTo(User::class,'created_by_user_id'); }
}