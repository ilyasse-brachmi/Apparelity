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
        'id','name','address','supplier','product_id'
    ];

    public function scopeSelection($query)
    {

        return $query->select('id','name','supplier', 'address');
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function convertToArray($resource){
        if(!$resource){
            return null;
        }
        $data=[
            'id'=>$resource->id,
            'name'=>$resource->name,
            'address'=>$resource->address,
            'productId'=>$resource->product->id,
            'productName'=>$resource->product->name,
        ];
        return response()->json($data);
    }
    public function children()
    {
        return $this->hasMany(Material::class, 'material_parent','id');
    }

    public function parent()
    {
        return $this->belongsTo(Material::class, 'material_parent');
    }
}
