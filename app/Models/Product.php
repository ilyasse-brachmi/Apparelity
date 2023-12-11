<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Plank\Mediable\Mediable;

class Product extends Model
{
    use HasFactory, Notifiable,Mediable;

    public $timestamps = true;


    protected $table = 'product';

    protected $fillable = [
        'id','name', 'price','description','production_date','company_id','category_id'
    ];

    public function scopeSelection($query)
        {

        return $query->select('id', 'name', 'price','description','production_date');
    }
    public function materials()
    {
        return $this->hasMany(Material::class, 'product_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function getPicAttribute()
    {
        if ($this->hasMedia('image_product')) {
            return $this->firstMedia('image_product')->getUrl();
        }
        return 0;
    }
    public function convertToArray($resource){
        if(!$resource){
            return null;
        }
        $data=[
            'id'=>$resource->id,
            'name'=>$resource->name,
            'price'=>$resource->price,
            'description'=>$resource->description,
            'production_date'=>$resource->production_date,
            'product_image'=>$resource->getPicAttribute(),
            'company_id'=>$resource->company->id,
            'company_name'=>$resource->company->name,
            'category_id'=>$resource->category->id,
            'category_name'=>$resource->category->name,
        ];
        return response()->json($data);
    }

}
