<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetallType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];
    public function categories(){
        return $this->hasMany(MetallCategories::class);
    }

    public function metalls(){
        return $this->hasMany(Metall::class);
    }

    public function remains(){
        return $this->hasMany(Remain::class);
    }
}
