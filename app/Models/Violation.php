<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Ramsey\Uuid\Uuid;

class Violation extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'nip',
        'offender',
        'type',
        'class',
        'position',
        'department',
        'desc',
        'evidence',
        'status',
        'user_id',
        'place',
        'regulation_section',
        'regulation_letter',
        'regulation_number',
        'regulation_year',
        'regulation_about',
        'examination_place',
        'examination_date',
        'examination_time',
        'session_date',
        'session_decision_report',
        'session_official_report',
        'verified_at'
    ];

    protected $appends = [
        'formatted_date',
        'formatted_verified_at',
    ];

    public function getFormattedDateAttribute(): string
    {
        return Carbon::parse($this->date)->translatedFormat('d F Y');
    }

    public function getFormattedVerifiedAtAttribute(): string
    {
        return $this->verified_at
            ? Carbon::parse($this->verified_at)->translatedFormat('d F Y \P\u\k\u\l H:i \W\I\T\A')
            : '-';
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    protected static function boot()
    {
        parent::boot();
        self::saving(function ($model) {
            if (!$model->exists) {
                $model->uuid = (string) Uuid::uuid4();
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function unit_kerja(): BelongsTo
    {
        return $this->belongsTo(UnitKerja::class, 'department');
    }
}
