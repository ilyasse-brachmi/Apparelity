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
        'id','name', 'address','description','user_id'
    ];

    public function scopeSelection($query)
    {
        return $query->select('id', 'name', 'address','description');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'company_id');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
