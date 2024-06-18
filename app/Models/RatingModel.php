<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RatingModel extends Model
{
    use HasFactory;

    protected $table = 'ratings';

    protected $fillable = [
        'rating', 
        'komentar', 
        'id_package', 
        'id_user'
    ];

    public function paket()
    {
        return $this->belongsTo(PackagesModel::class, 'id_package');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
