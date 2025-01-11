<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpaceDetail extends Model
{
    protected $table = 'detail_penyimpanan';
    use HasFactory;
    protected $fillable = [
        'lokasi_id',
        'total_space',
        'used_space',
        'free_space',
    ];

    public function lokasi()
    {
        return $this->belongsTo(Location::class, 'lokasi_id');
    }
}
