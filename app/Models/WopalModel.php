<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WopalModel extends Model
{
    use HasFactory;
    protected $table = 'tb_wopal';
    protected $fillable = [
        'id', 'nama_wopal', 'alamat', 'no_hp', 'email', 'img_wopal', ' deskripsi', 'id_user', 'created_at', 'updated_at'
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
    public function package()
    {
        return $this->hasMany(PackagesModel::class, 'id_package');
    }
}
