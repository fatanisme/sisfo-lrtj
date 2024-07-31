<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Lrv;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Pendinasan extends Model
{
    use HasFactory;


    public function lrv(): BelongsTo
    {
        return $this->belongsTo(Lrv::class);
    }
}
