<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pendinasan;
use App\Models\Lrv;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stamformasi extends Model
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

    protected static function boot()
    {
        parent::boot();

        static::updating(function ($model) {
            // Set last_modified saat update
            $model->last_modified = now();
        });

        static::creating(function ($model) {
            // Tidak mengubah last_modified saat create
            $model->last_modified = null;
        });
    }
}
