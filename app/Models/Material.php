<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Material extends Model
{
    use HasFactory;

    public $timestamps = true;


    protected $table = 'material';
    use Notifiable;

    protected $fillable = [
        'id','name', 'origin','supplier','address','product_id'
    ];

    public function scopeSelection($query)
    {

        return $query->select('id','name', 'origin','supplier','address');
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
