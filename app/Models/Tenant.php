<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $fillable = [
        'room_id', 'name', 'phone', 'national_id',
        'move_in_date', 'move_out_date', 'is_active'
    ];

    protected $casts = [
        'move_in_date'  => 'date',
        'move_out_date' => 'date',
        'is_active'     => 'boolean',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}