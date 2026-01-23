<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

class Lapangan extends Model implements AuditableContract
{
    use SoftDeletes, Auditable;

    protected $table = "lapangan";

    protected $fillable = [
        "nama",
        "tanggal",
    ];

    protected $auditInclude = [
        'nama',
        'tanggal'
    ];

    public function jadwal(): HasMany
    {
        return $this->hasMany(Jadwal::class, "lapangan_id");
    }
}
