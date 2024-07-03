<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\BrandCar;

class ModelCar extends Model
{
    use HasFactory;

    protected $table = "model_cars";

    protected $fillable = [
        "brand_id",
        "model_name",
        "model_image",
        "number_doors",
        "places",
        "air_bag",
        "abs"
    ];

    public function rules()
    {
        return [
            "brand_id" => "exists:brands,id",
            "model_name" => " required|unique:model_cars,model_name, ".$this->id."",
            "model_image" => "required|file|mimes:png",
            "number_doors" => "required|integer|digits_between:1,5",
            "places" => "required|integer|digits_between:1,20",
            "air_bag" => "required|boolean",
            "abs" => "required|boolean",
        ];
    }

    public function brandCarRelation() {
        return $this->belongsTo(BrandCar::class, 'brand_id', 'id');
    }
    

}
