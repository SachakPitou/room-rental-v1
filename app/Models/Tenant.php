<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $fillable = [
        'room_id', 'name', 'phone', 'national_id',
        'move_in_date',  'check_in_time',
        'move_out_date', 'check_out_time',
        'notes', 'is_active'
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

    // Helper: formatted check-in
    public function getCheckInAttribute(): string
    {
        $date = $this->move_in_date?->format('d M Y') ?? '—';
        $time = $this->check_in_time
                    ? ' · ' . \Carbon\Carbon::parse($this->check_in_time)->format('h:i A')
                    : '';
        return $date . $time;
    }

    // Helper: formatted check-out
    public function getCheckOutAttribute(): string
    {
        if (!$this->move_out_date) return '—';
        $date = $this->move_out_date->format('d M Y');
        $time = $this->check_out_time
                    ? ' · ' . \Carbon\Carbon::parse($this->check_out_time)->format('h:i A')
                    : '';
        return $date . $time;
    }

    // Helper: how many days stayed
    public function getDaysStayedAttribute(): int
    {
        $from = $this->move_in_date;
        $to   = $this->move_out_date ?? now();
        return (int) $from->diffInDays($to);
    }
}