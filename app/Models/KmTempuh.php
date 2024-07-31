<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Lrv;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KmTempuh extends Model
{
    use HasFactory;
    
    public function lrv(): BelongsTo
    {
        return $this->belongsTo(Lrv::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
