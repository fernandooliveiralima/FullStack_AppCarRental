<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\ModelCar;

class Car extends Model
{
    use HasFactory;

    protected $table = "cars";

    protected $fillable = [
        "model_cars_id",
        "plate",
        "available",
        "km"
    ];

    public function rules()
    {
        return [
            "model_cars_id" => "exists:model_cars,id",
            "plate" => " required",
            "available" => "required",
            "km" => "required"
        ];
    }

    public function modelCarRelation(){
        return $this->belongsTo(ModelCar::class, "model_cars_id", "id");
    }

}
