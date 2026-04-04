<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'room_id', 'tenant_id', 'month',
        'monthly_fee',
        'prev_water', 'curr_water', 'water_rate', 'water_used',
        'water_fee_riel', 'water_fee_usd',
        'water_mode', 'water_fixed_fee',          // ← add these
        'prev_electric', 'curr_electric', 'electric_rate', 'electric_used',
        'electric_fee_riel', 'electric_fee_usd',
        'extra_fee', 'extra_fee_note',
        'exchange_rate', 'total_usd', 'status', 'paid_date'
    ];

    protected $casts = [
        'paid_date' => 'date',
    ];

    public function room()   { return $this->belongsTo(Room::class); }
    public function tenant() { return $this->belongsTo(Tenant::class); }
}