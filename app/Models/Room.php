<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'name', 'monthly_fee', 'water_rate', 'electric_rate',
        'water_mode', 'water_fixed_fee', 'status'
    ];

    public function tenants()
    {
        return $this->hasMany(Tenant::class);
    }

    public function activeTenant()
    {
        return $this->hasOne(Tenant::class)->where('is_active', true);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    // Helper: is this room using fixed water billing?
    public function isFixedWater(): bool
    {
        return $this->water_mode === 'fixed';
    }
}