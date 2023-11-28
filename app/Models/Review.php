<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $table = 'review';
    protected $fillable = [
        'id','f_name', 'l_name','email','description'
    ];

    public function scopeSelection($query)
    {
        return $query->select('id', 'f_name','l_name', 'email','description');
    }
}
