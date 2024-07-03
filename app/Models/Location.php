<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $table = "locations";
    protected $fillable = [
        "costumer_id",
        "car_id",
        "date_start_period",
        "date_end_period",
        "end_date_realized_period",
        "daily_value",
        "km_start",
        "km_end"
    ];

    public function rules(){
        return [
            "costumer_id" => "required",
            "car_id" => "required",
            "date_start_period" => "required",
            "date_end_period" => "required",
            "end_date_realized_period" => "required",
            "daily_value" => "required",
            "km_start" => "required",
            "km_end" => "required"
        ];
    }

}
