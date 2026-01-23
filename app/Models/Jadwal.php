<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

class Jadwal extends Model implements AuditableContract
{
    use SoftDeletes, Auditable;

    protected $table = "jadwal";

    protected $fillable = [
        "user_id",
        "lapangan_id",
        "jam_mulai",
        "jam_berhenti"
    ];

    protected $auditInclude = [
        "user_id",
        "lapangan_id",
        "jam_mulai",
        "jam_berhenti"
    ];

    public function lapangan(): BelongsTo
    {
        return $this->belongsTo(Lapangan::class, 'lapangan_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
