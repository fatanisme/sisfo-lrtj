<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BulkPerawatan extends Model
{
    protected $fillable = ["tanggal", "status_perawatan"];

    use HasFactory;
}
