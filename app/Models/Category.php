<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public $timestamps = true;


    protected $table = 'category';
    use Notifiable;

    protected $fillable = [
        'id','name'
    ];

    public function scopeSelection($query)
    {

        return $query->select('id', 'name');
    }
}