<?php
namespace App\Modules\Inventory\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class AssetCategory extends Model {
    protected $fillable = ['parent_id','code','name','description','is_active'];
    protected $casts = ['is_active'=>'boolean'];
    public function parent(): BelongsTo { return $this->belongsTo(self::class,'parent_id'); }
    public function children(): HasMany { return $this->hasMany(self::class,'parent_id'); }
    public function assets(): HasMany { return $this->hasMany(Asset::class); }
}