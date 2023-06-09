<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Name extends Model
{
    use HasFactory;

    protected $table = 'hoten';   

    public function user()
    {
        return $this->belongsTo(User::class, 'maHT', 'id');
    }

}
