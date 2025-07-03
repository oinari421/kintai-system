<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    // 一括代入を許可するカラム
    protected $fillable = ['user_id', 'clock_in', 'clock_out'];

    // 自動でCarbonインスタンスにキャストする
    protected $casts = [
        'clock_in' => 'datetime',
        'clock_out' => 'datetime',
    ];
}
