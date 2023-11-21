<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Admin extends Model
{
    use HasFactory;

    public $timestamps = true;


    protected $table = 'admin';
    use Notifiable;

    protected $fillable = [
        'id','f_name', 'l_name',
    ];

    public function scopeSelection($query)
    {

        return $query->select('id', 'f_name', 'l_name');
    }
}
