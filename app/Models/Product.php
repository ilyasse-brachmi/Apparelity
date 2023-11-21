<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Product extends Model
{
    use HasFactory;

    public $timestamps = true;


    protected $table = 'product';
    use Notifiable;

    protected $fillable = [
        'id','name', 'price','description','production_date'
    ];

    public function scopeSelection($query)
        {

        return $query->select('id', 'name', 'price','description','production_date');
    }
}
