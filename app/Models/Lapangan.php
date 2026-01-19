<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lapangan extends Model
{
    protected $table = "lapangan";

    protected $fillable = [
        "nama",
        "tanggal",
    ];

    public function jadwal(): HasMany
    {
        return $this->hasMany(Jadwal::class, "lapangan_id");
    }
}
