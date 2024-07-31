<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Perawatan;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Fasilitas extends Model
{
    use HasFactory;
    
    public function perawatan(): BelongsTo
    {
        return $this->belongsTo(Perawatan::class);
    }
}
