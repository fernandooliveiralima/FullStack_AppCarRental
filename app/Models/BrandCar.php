<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\ModelCar;



class BrandCar extends Model
{
    use HasFactory;

    protected $table = "brands";
    protected $fillable = ["brand_name", "brand_image"];

    public function rules()
    {
        return [
            "brand_name" => "required|unique:brands,brand_name, ".$this->id." ",
            "brand_image" => "required|file|mimes:png"
        ];
    }
    public function feedback()
    {
        return [
            "required" => "The Field :attribute Is Mandatory!",
            "brand_name.unique" => "The brand name: already exists!"
        ];
    }

    public function modelCarRelation() {
        return $this->hasMany(ModelCar::class, 'brand_id', 'id');
    }
    

}
