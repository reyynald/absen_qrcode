<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    protected $table = 'attendance';

    protected $fillable = [
        'session_id',
        'user_id',
        'name',
        'email',
        'phone',
        'institution',
        'jurusan',
        'nim_nip',
        'jam_datang',
        'jam_pulang',
        'signature',
        'checked_in_at',
    ];

    protected $casts = [
        'checked_in_at' => 'datetime',
        'jam_datang' => 'string',
        'jam_pulang' => 'string',
    ];

    public function session(): BelongsTo
    {
        return $this->belongsTo(AttendanceSession::class, 'session_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
