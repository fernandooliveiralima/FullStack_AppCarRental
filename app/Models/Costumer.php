<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Costumer extends Model
{
    use HasFactory;

    protected $table = 'costumers';
    protected $fillable = ['costumer_name'];

    public function rules()
    {
        return ["costumer_name" => "required"];
    }
}
