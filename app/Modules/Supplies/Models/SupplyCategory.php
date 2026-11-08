<?php
namespace App\Modules\Supplies\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class SupplyCategory extends Model {
    protected $fillable = ['parent_id','code','name','is_active'];
    protected $casts = ['is_active'=>'boolean'];
    public function parent(): BelongsTo { return $this->belongsTo(self::class,'parent_id'); }
    public function children(): HasMany { return $this->hasMany(self::class,'parent_id'); }
    public function items(): HasMany { return $this->hasMany(SupplyItem::class); }
}