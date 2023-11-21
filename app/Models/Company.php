<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Company extends Model
{
    use HasFactory;

    public $timestamps = true;
    protected $table = 'company';
    use Notifiable;

    protected $fillable = [
        'id','name', 'address','description'
    ];

    public function scopeSelection($query)
    {
        return $query->select('id', 'name', 'address','description');
    }
}
