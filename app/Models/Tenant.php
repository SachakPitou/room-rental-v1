<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Tenant extends Model
{
    protected $fillable = [
        'room_id', 'name', 'phone', 'national_id',
        'move_in_date',  'check_in_time',
        'move_out_date', 'check_out_time',
        'notes', 'is_active',
        'id_card_path', 'id_card_type',
        'id_card_original_name', 'id_card_uploaded_at',
        'photo_path',   // ← add this
    ];

    // Has profile photo?
    public function hasPhoto(): bool
    {
        return !empty($this->photo_path);
    }

    // Full photo URL
    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo_path
            ? asset('storage/' . $this->photo_path)
            : null;
    }

    protected $casts = [
        'move_in_date'       => 'date',
        'move_out_date'      => 'date',
        'is_active'          => 'boolean',
        'id_card_uploaded_at'=> 'datetime',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function getCheckInAttribute(): string
    {
        $date = $this->move_in_date?->format('d M Y') ?? '—';
        $time = $this->check_in_time
            ? ' · ' . Carbon::parse($this->check_in_time)->format('h:i A')
            : '';
        return $date . $time;
    }

    public function getCheckOutAttribute(): string
    {
        if (!$this->move_out_date) return '—';
        $date = $this->move_out_date->format('d M Y');
        $time = $this->check_out_time
            ? ' · ' . Carbon::parse($this->check_out_time)->format('h:i A')
            : '';
        return $date . $time;
    }

    public function getDaysStayedAttribute(): int
    {
        $from = $this->move_in_date;
        $to   = $this->move_out_date ?? now();
        return (int) $from->diffInDays($to);
    }

    // Has document uploaded?
    public function hasDocument(): bool
    {
        return !empty($this->id_card_path);
    }

    // Full storage URL
    public function getDocumentUrlAttribute(): ?string
    {
        return $this->id_card_path
            ? asset('storage/' . $this->id_card_path)
            : null;
    }

    // Is the document an image?
    public function isDocumentImage(): bool
    {
        if (!$this->id_card_original_name) return false;
        $ext = strtolower(pathinfo($this->id_card_original_name, PATHINFO_EXTENSION));
        return in_array($ext, ['jpg', 'jpeg', 'png', 'webp']);
    }

    // Is the document a PDF?
    public function isDocumentPdf(): bool
    {
        if (!$this->id_card_original_name) return false;
        $ext = strtolower(pathinfo($this->id_card_original_name, PATHINFO_EXTENSION));
        return $ext === 'pdf';
    }

    public function getIdCardTypeLabelAttribute(): string
    {
        return match($this->id_card_type) {
            'national_id' => 'National ID Card',
            'passport'    => 'Passport',
            'other'       => 'Other Document',
            default       => 'Document',
        };
    }
}