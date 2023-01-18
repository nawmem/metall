<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Remain extends Model
{

    protected $fillable = [
        'metall_types_id',
        'metall_categories_id',
        'remains'
    ];
    use HasFactory;

    public function typeMetalls(){
        return $this->belongsTo(MetallType::class);
    }

    public function metallCategories(){
        return $this->belongsTo(MetallCategories::class);
    }


}
