<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Metall extends Model
{
    use HasFactory;

    protected $fillable = [
        'event',
        'name', // название метала
        'price_one', // цена за киллограм
        'massa', // масса взвешивания
        'percentage_of_blockage', // процент засора
        'price_all', // итоговая цена
        "blockage", // засор
        'metall_types_id', // тип метала
        'metall_categories_id', //категория металла
    ];

    public function typeMetall(){
        return $this->belongsTo(MetallType::class);
    }


    public function metallCategories(){
        return $this->belongsTo(MetallCategories::class);
    }

}
