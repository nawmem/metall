<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetallCategories extends Model
{

    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'metall_types_id'
    ];

    public function metallTypes(){
        return $this->belongsTo(MetallType::class);
    }

    public function metalls(){
        return $this->hasMany(Metall::class);
    }

    public function remains(){
        return $this->hasOne(Remain::class);
    }

    public function fromCategoriesId(){
        return $this->hasMany(TransferMetall::class, 'from_categories_id');
    }

    public function inCategoriesId(){
        return $this->hasMany(TransferMetall::class, 'in_categories_id');
    }

}
