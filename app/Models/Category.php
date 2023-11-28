<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

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
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
