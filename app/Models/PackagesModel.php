<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackagesModel extends Model
{
    use HasFactory;
    protected $table = 'tb_packages';
    protected $fillable = [
        'id',
        'nama_paket',
        'harga',
        'gmb_paket',
        'deskrisi',
        'id_wedding',
        'id_user',
        'created_at',
        'updated_at',
    ];

    public function wopal()
    {
        return $this->belongsTo(WopalModel::class, 'id_wedding');
    }
    
}
