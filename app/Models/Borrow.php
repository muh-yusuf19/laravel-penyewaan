<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Car;

class Borrow extends Model
{
    use HasFactory;

    protected $fillable = ['tgl_mulai', 'tgl_selesai', 'user_id', 'car_id', 'total_harga'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
