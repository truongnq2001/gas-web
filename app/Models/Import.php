<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    use HasFactory;

    protected $table = 'sonhap';

    protected $fillable = [
        'soluong',
        'maNV',
        'maGAS',
        'maNCC',
        'ngaythang',
    ];

    public $timestamps = false;
}
