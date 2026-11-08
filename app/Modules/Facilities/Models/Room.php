<?php
namespace App\Modules\Facilities\Models;
use App\Modules\Inventory\Models\Location;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Room extends Model {
    protected $fillable = ['location_id','room_code','capacity','room_type','status','usage_notes'];
    protected $casts = ['capacity'=>'integer'];
    public function location(): BelongsTo { return $this->belongsTo(Location::class); }
    public function bookings(): HasMany { return $this->hasMany(RoomBooking::class); }
    public function maintenanceTickets(): HasMany { return $this->hasMany(\App\Modules\Maintenance\Models\MaintenanceTicket::class,'target_room_id'); }
}