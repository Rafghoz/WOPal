<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingModel extends Model
{
    use HasFactory;
    protected $table = 'tb_booking';
    protected $fillable = [
        'id',
        'catatan',
        'tgl_nk',
        'id_package',
        'id_user',
    ];
    
    public function package()
    {
        return $this->belongsTo(PackagesModel::class, 'id_package');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
