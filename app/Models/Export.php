<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Export extends Model
{
    use HasFactory;

    protected $table = 'soxuat';

    protected $fillable = [
        'soluong',
        'maNV',
        'maGAS',
        'maDL',
        'ngaythang',
    ];

    public $timestamps = false;
}
